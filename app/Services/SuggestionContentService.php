<?php

namespace App\Services;

use App\Models\Cluster;
use App\Models\ModelPlan;
use App\Models\SuggestionSet;
use App\Models\Tag;
use App\Services\DataTransferObjects\SuggestionContentDto;
use App\Services\Gemini\CatchphraseGenerationService;
use App\Services\Gemini\ImageGenerationService;
use App\Services\Gemini\ModelPlanGenerationService;
use App\Services\Gemini\SpotGenerationService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * AIコンテンツ生成のファサード (Façade)
 * キャッシュ（マスターデータ）の有無を確認し、
 * 必要に応じて各AI生成サービスを呼び出す。
 *
 * @see MVP_旅先提案アルゴリズム設計 B. ドメインサービス
 */
class SuggestionContentService
{
    /**
     * @var Collection<int, Tag>|null ユーザーが入力したタグのコレクション
     */
    private ?Collection $inputTags = null;

    public function __construct(
        // C. インフラストラクチャサービス (AI Communication)
        private readonly SpotGenerationService $spotGenerationService,
        private readonly ModelPlanGenerationService $modelPlanGenerationService,
        private readonly CatchphraseGenerationService $catchphraseGenerationService,
        private readonly ImageGenerationService $imageGenerationService
    ) {
    }

    /**
     * クラスタと入力に基づき、提案コンテンツ（プラン、キャッチコピー、画像）を生成または選定する
     *
     * @param Cluster $cluster
     * @param SuggestionSet $suggestionSet
     * @return SuggestionContentDto 提案アイテムの作成に必要なID群
     * @throws Throwable
     */
    public function generateContentForCluster(
        Cluster $cluster,
        SuggestionSet $suggestionSet
    ): SuggestionContentDto {
        Log::info("[ContentService] Processing cluster: {$cluster->name} (ID: {$cluster->id})");

        // ユーザーが入力したタグID配列 からTagモデルのコレクションをロードする
        $this->loadInputTags($suggestionSet);

        // --- キャッシュ確認 (Cache Check) ---
        //
        // このクラスターに紐づくマスターデータ（ModelPlan）がDBに既に存在するか？
        $existingPlan = $this->findExistingModelPlan($cluster, $this->inputTags);

        if ($existingPlan) {
            // [Cache Hit時] のフロー
            // MVPの主要フロー
            $dto = $this->handleCacheHit($existingPlan, $this->inputTags);
        } else {
            // [Cache Miss時] のフロー
            // (例: 11地域目のリクエスト)
            $dto = $this->handleCacheMiss($cluster, $this->inputTags);
        }

        Log::info("[ContentService] Completed cluster: {$cluster->name}", ['plan_id' => $dto->modelPlanId]);
        return $dto;
    }

    /**
     * [Cache Hit時]
     * 既存のマスタープランを選定し、パーソナライズ要素（キャッチコピー、画像）のみをAIで動的生成する
     *
     * @param ModelPlan $modelPlan
     * @param Collection<int, Tag> $tags
     * @return SuggestionContentDto
     * @throws Throwable
     */
    private function handleCacheHit(ModelPlan $modelPlan, Collection $tags): SuggestionContentDto
    {
        Log::info("[ContentService] Cache HIT for cluster: {$modelPlan->cluster_id}. Using ModelPlan: {$modelPlan->id}");

        // 1. キャッチコピーはパーソナライズのため動的生成
        $catchphrase = $this->catchphraseGenerationService->generateCatchphrase($modelPlan, $tags);

        // 2. キービジュアルも動的生成
        // ModelPlanに紐づくリレーション（items.spot）をロードしておく
        $modelPlan->loadMissing('items.spot');
        $image = $this->imageGenerationService->generateImageForModelPlan($modelPlan);

        return new SuggestionContentDto(
            clusterId: $modelPlan->cluster_id,
            modelPlanId: $modelPlan->id,
            catchphraseId: $catchphrase->id,
            keyVisualImageId: $image->id
        );
    }

    /**
     * [Cache Miss時]
     * スポット、モデルプラン、キャッチコピー、画像のすべてをAIで動的生成し、DBに保存する
     *
     * @param Cluster $cluster
     * @param Collection<int, Tag> $tags
     * @return SuggestionContentDto
     * @throws Throwable
     */
    private function handleCacheMiss(Cluster $cluster, Collection $tags): SuggestionContentDto
    {
        Log::warning("[ContentService] Cache MISS for cluster: {$cluster->id}. Generating all content...");

        // 1. スポット群の生成
        $spots = $this->spotGenerationService->generateSpotsForCluster($cluster);
        if ($spots->isEmpty()) {
            throw new \RuntimeException("SpotGenerationService returned no spots for cluster: {$cluster->id}");
        }

        // 2. モデルプランの生成
        $modelPlan = $this->modelPlanGenerationService->generatePlan($cluster, $spots, $tags);

        // 3. キャッチコピーの生成
        $catchphrase = $this->catchphraseGenerationService->generateCatchphrase($modelPlan, $tags);

        // 4. キービジュアルの生成
        // $modelPlanにはリレーションがロード済み
        $image = $this->imageGenerationService->generateImageForModelPlan($modelPlan);

        return new SuggestionContentDto(
            clusterId: $cluster->id,
            modelPlanId: $modelPlan->id,
            catchphraseId: $catchphrase->id,
            keyVisualImageId: $image->id
        );
    }

    /**
     * SuggestionSetから入力タグID配列を取得し、Tagモデルのコレクションをロードする
     *
     * @param SuggestionSet $suggestionSet
     */
    private function loadInputTags(SuggestionSet $suggestionSet): void
    {
        // 既にロード済みの場合はスキップ
        if ($this->inputTags !== null) {
            return;
        }

        $tagIds = $suggestionSet->input_tags_json ?? [];
        if (empty($tagIds)) {
            $this->inputTags = new Collection();
            return;
        }

        // DBからTagモデルを取得
        $this->inputTags = Tag::query()
            ->whereIn('id', $tagIds)
            ->get();
    }

    /**
     * [Cache Hit] のための既存プラン検索ロジック
     *
     * @param Cluster $cluster
     * @param Collection<int, Tag> $tags
     * @return ModelPlan|null
     */
    private function findExistingModelPlan(Cluster $cluster, Collection $tags): ?ModelPlan
    {
        // MVPでは、タグに関わらず、そのクラスターに紐づく
        // 最初のプラン（またはデフォルトプラン）を返す
        // TODO: 将来的に、入力タグ($tags)に基づいて最適なプランを選定するロジックに強化する
        return ModelPlan::query()
            ->where('cluster_id', $cluster->id)
            ->orderBy('is_default', 'desc') // デフォルトプランを優先
            ->orderBy('id', 'asc') // IDが若いものを優先
            ->first();
    }
}
