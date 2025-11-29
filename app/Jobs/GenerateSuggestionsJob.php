<?php

namespace App\Jobs;

use App\Data\ProcessingDetailsData;
use App\Enums\SuggestionStatus;
use App\Models\SuggestionSet;
use App\Services\ClusterSelectorService;
use App\Services\TravelTimeCalculatorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * 旅行提案生成ジョブ（簡素化版）
 *
 * 非同期AI分析で事前計算されたデータから旅行提案を生成する
 *
 * 処理フロー:
 * 1. クラスター選定（確率的重みづけ）
 * 2. 各クラスターの既存モデルプランを選択
 * 3. 移動時間を計算
 * 4. suggestion_set_model_plans ピボットテーブルに保存
 *
 * 注意: AI分析（スポット詳細、キャッチフレーズ、画像選定など）は
 * 事前にバックグラウンドで非同期実行されている前提
 */
class GenerateSuggestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** ジョブのタイムアウト時間（秒） - 簡素化により大幅に短縮 */
    public int $timeout = 60;

    public function __construct(
        public SuggestionSet $suggestionSet
    ) {}

    /**
     * ジョブの実行
     */
    public function handle(
        ClusterSelectorService $clusterSelector,
        TravelTimeCalculatorService $travelTimeCalculator
    ): void {
        try {
            // Step 1: クラスター選定
            $this->suggestionSet->update([
                'status' => SuggestionStatus::ProcessingClusters,
            ]);

            $clusters = $clusterSelector->selectClusters(
                $this->suggestionSet->input_latitude,
                $this->suggestionSet->input_longitude,
                3
            );

            if ($clusters->isEmpty()) {
                // クラスターが見つからない場合（正常な結果）
                $this->suggestionSet->update([
                    'status' => SuggestionStatus::NoResults,
                ]);

                Log::info('[GenerateSuggestionsJob] No clusters with model plans found', [
                    'suggestion_set_id' => $this->suggestionSet->id,
                ]);

                return;
            }

            $clusterNames = $clusters->pluck('name')->toArray();
            $this->suggestionSet->update([
                'processing_details' => new ProcessingDetailsData(
                    found_clusters: $clusterNames
                ),
            ]);

            Log::info('[GenerateSuggestionsJob] Clusters selected', [
                'suggestion_set_id' => $this->suggestionSet->id,
                'clusters' => $clusterNames,
            ]);

            // Step 2: 既存のモデルプランを選択して提案を作成
            $this->suggestionSet->update([
                'status' => SuggestionStatus::GeneratingContent,
            ]);

            $attachments = [];
            $displayOrder = 1;

            foreach ($clusters as $cluster) {
                try {
                    // このクラスターの画像選定が完了したモデルプランを取得
                    // まずデフォルトプランを優先
                    $modelPlan = $cluster->modelPlans()
                        ->where('is_default', true)
                        ->whereNotNull('image_selection_analyzed_by_model_id')
                        ->first();

                    if (! $modelPlan) {
                        // デフォルトプランがない場合は画像選定が完了した最初のプランを使用
                        $modelPlan = $cluster->modelPlans()
                            ->whereNotNull('image_selection_analyzed_by_model_id')
                            ->first();
                    }

                    if (! $modelPlan) {
                        // 画像選定が完了したモデルプランが存在しない場合はスキップ
                        // （通常はClusterSelectorServiceで除外されているため到達しないはず）
                        Log::warning('[GenerateSuggestionsJob] No model plan with completed image selection found', [
                            'cluster_id' => $cluster->id,
                        ]);
                        continue;
                    }

                    // キャッチフレーズがまだ生成されていない場合の警告
                    if (! $modelPlan->catchphrase) {
                        Log::warning('[GenerateSuggestionsJob] Model plan missing catchphrase (async analysis pending)', [
                            'model_plan_id' => $modelPlan->id,
                            'cluster_id' => $cluster->id,
                        ]);
                    }

                    // 移動時間を計算
                    $travelTimeMinutes = $travelTimeCalculator->calculateTravelTime(
                        $this->suggestionSet->input_latitude,
                        $this->suggestionSet->input_longitude,
                        $cluster
                    );
                    $travelTimeText = $travelTimeCalculator->formatTravelTimeText($travelTimeMinutes);

                    // ピボットテーブルに追加するデータを準備
                    $attachments[$modelPlan->id] = [
                        'display_order' => $displayOrder,
                        'generated_travel_time_text' => $travelTimeText,
                        'created_at' => now(),
                    ];

                    $displayOrder++;

                    Log::info('[GenerateSuggestionsJob] Model plan selected', [
                        'cluster_id' => $cluster->id,
                        'model_plan_id' => $modelPlan->id,
                        'travel_time' => $travelTimeText,
                    ]);

                } catch (\Exception $e) {
                    Log::error('[GenerateSuggestionsJob] Failed to process cluster', [
                        'cluster_id' => $cluster->id,
                        'error' => $e->getMessage(),
                    ]);
                    // エラーが発生してもジョブは継続
                }
            }

            // Step 3: suggestion_set_model_plans ピボットテーブルに一括保存
            if (! empty($attachments)) {
                $this->suggestionSet->modelPlans()->attach($attachments);

                Log::info('[GenerateSuggestionsJob] Attached model plans to suggestion set', [
                    'suggestion_set_id' => $this->suggestionSet->id,
                    'count' => count($attachments),
                ]);
            } else {
                // モデルプランが添付できなかった場合（正常な結果）
                $this->suggestionSet->update([
                    'status' => SuggestionStatus::NoResults,
                ]);

                Log::info('[GenerateSuggestionsJob] No model plans available for selected clusters', [
                    'suggestion_set_id' => $this->suggestionSet->id,
                    'clusters' => $clusterNames,
                ]);

                return;
            }

            // Step 4: 完了
            $this->suggestionSet->update([
                'status' => SuggestionStatus::Complete,
            ]);

            Log::info('[GenerateSuggestionsJob] Suggestion generation completed', [
                'suggestion_set_id' => $this->suggestionSet->id,
                'model_plans_count' => count($attachments),
            ]);

        } catch (\Exception $e) {
            // エラー発生時はステータスをfailedに更新
            $this->suggestionSet->update([
                'status' => SuggestionStatus::Failed,
                'processing_details' => new ProcessingDetailsData(
                    error: $e->getMessage(),
                    trace: $e->getTraceAsString()
                ),
            ]);

            Log::error('[GenerateSuggestionsJob] Failed', [
                'suggestion_set_id' => $this->suggestionSet->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // ジョブを失敗させる
            $this->fail($e);
        }
    }
}
