<?php

namespace App\Services\Gemini;

use App\Enums\TravelMode;
use App\Models\Cluster;
use App\Models\ModelPlan;
use App\Models\Spot;
use App\Models\Tag;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * AIによるモデルプランの生成とDB保存を担当するサービス。
 *
 * @see MVP_旅先提案アルゴリズム設計 C. インフラストラクチャサービス
 */
class ModelPlanGenerationService extends BaseGeminiClient
{
    /**
     * AIを使用してモデルプランを生成し、DBにアトミックに保存する。
     *
     * @param Cluster $cluster 対象のクラスター
     * @param Collection<int, Spot> $spots このプランで使用するスポットのコレクション
     * @param Collection<int, Tag> $tags ユーザーが入力したタグのコレクション（プランのテーマとして使用）
     * @param int $durationHours プランの目安時間（デフォルト: 6時間）
     * @return ModelPlan 生成されたModelPlanモデル
     * @throws Throwable AIのレスポンスが不正、またはDB保存に失敗した場合
     */
    public function generatePlan(
        Cluster $cluster,
        Collection $spots,
        Collection $tags,
        int $durationHours = 6
    ): ModelPlan {
        Log::info(
            "[ModelPlanGeneration] Generating {$durationHours}-hour plan for cluster: {$cluster->name}",
            [
                'cluster_id' => $cluster->id,
                'spot_count' => $spots->count(),
                'tags' => $tags->pluck('name')->implode(', ')
            ]
        );

        // 1. AIへの指示（プロンプト）を構築
        $prompt = $this->buildPrompt(
            $cluster->name,
            $spots,
            $tags,
            $durationHours
        );

        // 2. BaseGeminiClient経由でAI APIをコール
        $response = $this->generateContent($prompt);

        // 3. AIのレスポンスをDBに保存
        // この処理は GenerateSuggestionsJob のDBトランザクション内で実行されるため、
        // ここで例外が発生すればジョブ全体がロールバックされる。
        $modelPlan = $this->savePlanToDb($response, $cluster, $spots);

        Log::info(
            "[ModelPlanGeneration] Successfully generated ModelPlan ID: {$modelPlan->id} for cluster: {$cluster->name}"
        );

        return $modelPlan;
    }

    /**
     * AIへの指示（プロンプト）を構築する
     *
     * @param string $clusterName
     * @param Collection<int, Spot> $spots
     * @param Collection<int, Tag> $tags
     * @param int $durationHours
     * @return string
     */
    private function buildPrompt(
        string $clusterName,
        Collection $spots,
        Collection $tags,
        int $durationHours
    ): string {
        $theme = $tags->isEmpty()
            ? "定番の"
            : $tags->pluck('name')->implode('、') . "をテーマにした";

        // AIがどのスポットIDを使うべきか明確に指示する
        $spotListPrompt = $spots->map(
            fn(Spot $spot) => "- ID {$spot->id}: {$spot->name} (推奨滞在時間: {$spot->min_duration_minutes}分)"
        )->implode("\n");

        // DB設計 とアルゴリズム設計 に基づき、
        // 必要なJSONキーを厳密に指定する
        return <<<PROMPT
        あなたはプロの旅行プランナーです。
        以下の条件に基づき、魅力的な日帰りモデルプランを1件作成してください。

        # 条件
        - 場所: {$clusterName}
        - テーマ: {$theme}
        - 全体の所要時間: 約{$durationHours}時間
        - 利用可能なスポットリスト (必ずこのリスト内のIDを使用してください):
        {$spotListPrompt}

        # 出力形式
        以下のキーを持つJSONオブジェクトを1つだけ生成してください。
        - "plan_name": (string) プランの魅力的な名前 (例: "{$theme} {$clusterName}満喫プラン")
        - "plan_description": (string) プランの概要。100文字程度の説明文。
        - "total_duration_minutes": (int) プラン全体の合計所要時間（移動時間と滞在時間の合計、分単位）。
        - "items": (array) 以下のキーを持つオブジェクトの時系列配列。
            - "spot_id": (int) 利用可能なスポットリストから選んだスポットのID。
            - "display_order": (int) プラン内の順序 (1から昇順)。
            - "duration_minutes": (int) そのスポットでの滞在時間（分）。
            - "travel_time_to_next_minutes": (int) 次のスポットへの移動時間（分）。(最後のスポットの場合は0)
            - "travel_mode": (string) 次のスポットへの移動手段 (例: "徒歩", "バス", "車", "電車")。
            - "description": (string) 補足情報 (例: "ここでランチ休憩", "展望台からの景色がおすすめ")。

        JSONのみを返し、前後に説明文や ```json タグは不要です。
        PROMPT;
    }

    /**
     * AIのレスポンスを検証し、DBに保存する
     *
     * @param array $data AIから返されたパース済みのJSON配列
     * @param Cluster $cluster
     * @param Collection<int, Spot> $spots
     * @return ModelPlan
     * @throws \Exception AIのレスポンスが不正な場合
     */
    private function savePlanToDb(array $data, Cluster $cluster, Collection $spots): ModelPlan
    {
        // --- 1. レスポンスのバリデーション ---
        // AIが指定されたスポットID以外を返していないかチェックするためのMap
        $validSpotIds = $spots->pluck('id')->flip();

        // 必須キーの存在チェック
        if (!Arr::has($data, ['plan_name', 'plan_description', 'total_duration_minutes', 'items'])) {
            throw new \RuntimeException("[ModelPlanGeneration] AI response is missing required keys.");
        }

        $itemsData = $data['items'] ?? [];
        if (!is_array($itemsData) || empty($itemsData)) {
            throw new \RuntimeException("[ModelPlanGeneration] AI response 'items' is empty or invalid.");
        }

        // --- 2. model_plans (ヘッダー) の作成 ---
        //
        $modelPlan = ModelPlan::create([
            'cluster_id' => $cluster->id,
            'name' => $data['plan_name'],
            'description' => $data['plan_description'],
            'total_duration_minutes' => $data['total_duration_minutes'],
            'is_default' => false, // 動的生成されたプランはデフォルトではない
        ]);

        // --- 3. model_plan_items (詳細) の作成 ---
        $itemsToCreate = [];
        foreach ($itemsData as $item) {
            $spotId = $item['spot_id'] ?? null;

            // AIが幻覚のスポットIDを返していないか厳密にチェック
            if (!$spotId || !isset($validSpotIds[$spotId])) {
                Log::warning("[ModelPlanGeneration] AI returned an unknown spot_id: {$spotId}", [
                    'plan_id' => $modelPlan->id
                ]);
                // このアイテムはスキップする (または例外をスローする)
                continue;
            }

            //
            $itemsToCreate[] = [
                'display_order' => $item['display_order'],
                'spot_id' => $spotId,
                'duration_minutes' => $item['duration_minutes'],
                'travel_time_to_next_minutes' => $item['travel_time_to_next_minutes'],
                'travel_mode' => TravelMode::fromJapanese($item['travel_mode']),
                'description' => $item['description'],
            ];
        }

        if (empty($itemsToCreate)) {
            // 有効なアイテムが1件もなかった場合は、プラン自体を失敗（ロールバック）させる
            throw new \RuntimeException("[ModelPlanGeneration] No valid items found in AI response for plan {$modelPlan->id}.");
        }

        // リレーション経由で
        $modelPlan->items()->createMany($itemsToCreate);

        return $modelPlan;
    }
}
