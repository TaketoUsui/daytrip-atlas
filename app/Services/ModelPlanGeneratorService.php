<?php

namespace App\Services;

use App\Models\Cluster;
use App\Models\ModelPlan;
use App\Models\ModelPlanItem;
use App\Models\Spot;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * クラスターとスポット情報からモデルプランを自動生成するサービス
 */
class ModelPlanGeneratorService
{
    public function __construct(
        private readonly PromptLoaderService $promptLoader,
        private readonly GeminiClientService $geminiClient,
        private readonly LocationParserService $locationParser
    ) {}

    /**
     * クラスターに紐づくスポットをもとにモデルプランを生成
     *
     * @param  Cluster  $cluster  対象クラスター
     * @param  string  $travelTimeText  出発地からの移動時間テキスト
     * @return ModelPlan|null 生成されたモデルプラン（失敗時はnull）
     */
    public function generateModelPlan(Cluster $cluster, string $travelTimeText = '不明'): ?ModelPlan
    {
        try {
            // クラスターに紐づくスポットを取得
            $spots = $cluster->spots()
                ->whereNotNull('spot_role')
                ->get();

            if ($spots->isEmpty()) {
                Log::warning('No spots available for model plan generation', [
                    'cluster_id' => $cluster->id,
                ]);

                return null;
            }

            // スポットリストをフォーマット
            $spotsText = $this->formatSpotsForPrompt($spots);

            // プロンプトを読み込み
            $location = $this->locationParser->parseClusterName($cluster->name);
            $prompt = $this->promptLoader->load('model_plan_generation.txt', [
                'cluster_name' => $cluster->name,
                'prefecture' => $location['prefecture'] ?? '日本',
                'travel_time_text' => $travelTimeText,
                'available_spots' => $spotsText,
            ]);

            // Gemini APIでモデルプランを生成
            $response = $this->geminiClient->generateContent(
                $prompt,
                model: 'gemini-2.5-flash'
            );

            // JSONレスポンスをパース
            $data = $this->geminiClient->parseJsonResponse($response);

            // モデルプランを作成
            return $this->createModelPlan($cluster, $spots, $data);

        } catch (Exception $e) {
            Log::error('Failed to generate model plan', [
                'cluster_id' => $cluster->id,
                'cluster_name' => $cluster->name,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * スポット情報をプロンプト用にフォーマット
     *
     * @param  Collection<int, Spot>  $spots  スポットコレクション
     * @return string フォーマットされたスポットリスト
     */
    private function formatSpotsForPrompt(Collection $spots): string
    {
        $lines = [];

        foreach ($spots as $spot) {
            $lines[] = sprintf(
                '- %s（役割: %s、滞在時間: %d-%d分）',
                $spot->name,
                $spot->spot_role?->value ?? 'unknown',
                $spot->min_duration_minutes ?? 0,
                $spot->max_duration_minutes ?? 0
            );
        }

        return implode("\n", $lines);
    }

    /**
     * モデルプランとアイテムを作成
     *
     * @param  Cluster  $cluster  対象クラスター
     * @param  Collection<int, Spot>  $spots  利用可能なスポット
     * @param  array<string, mixed>  $planData  プランデータ
     * @return ModelPlan 作成されたモデルプラン
     *
     * @throws Exception 作成に失敗した場合
     */
    private function createModelPlan(Cluster $cluster, Collection $spots, array $planData): ModelPlan
    {
        // 必須フィールドのバリデーション
        if (! isset($planData['plan_title']) || ! isset($planData['items'])) {
            throw new Exception('Invalid plan data: missing required fields');
        }

        // モデルプランを作成
        $modelPlan = ModelPlan::create([
            'cluster_id' => $cluster->id,
            'name' => $planData['plan_title'],
            'description' => $planData['plan_description'] ?? null,
            'total_duration_minutes' => $planData['estimated_duration_minutes'] ?? 0,
            'is_default' => true, // 自動生成されたプランはデフォルトとする
        ]);

        // スポット名からIDのマッピングを作成
        $spotNameToId = $spots->pluck('id', 'name')->toArray();

        // モデルプランアイテムを作成
        foreach ($planData['items'] as $itemData) {
            $spotName = $itemData['spot_name'] ?? null;
            $spotId = $spotNameToId[$spotName] ?? null;

            if (! $spotId) {
                Log::warning('Spot not found for model plan item', [
                    'spot_name' => $spotName,
                    'model_plan_id' => $modelPlan->id,
                ]);

                continue;
            }

            ModelPlanItem::create([
                'model_plan_id' => $modelPlan->id,
                'display_order' => $itemData['order'] ?? 1,
                'spot_id' => $spotId,
                'duration_minutes' => $itemData['duration_minutes'] ?? 60,
                'travel_time_to_next_minutes' => 0, // 移動時間は後で計算可能
                'description' => $itemData['visit_notes'] ?? null,
            ]);
        }

        Log::info('Successfully created model plan', [
            'model_plan_id' => $modelPlan->id,
            'cluster_id' => $cluster->id,
            'items_count' => count($planData['items']),
        ]);

        return $modelPlan;
    }
}
