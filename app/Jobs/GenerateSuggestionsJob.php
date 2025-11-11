<?php

namespace App\Jobs;

use App\Data\ProcessingDetailsData;
use App\Enums\SuggestionStatus;
use App\Models\Image;
use App\Models\SuggestionSet;
use App\Models\SuggestionSetItem;
use App\Services\CatchphraseGeneratorService;
use App\Services\ClusterSelectorService;
use App\Services\TravelTimeCalculatorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * 提案生成ジョブ
 *
 * Phase 2: ダミー版（ステータス遷移、ダミーデータで提案生成）
 * Phase 4: AI統合（Gemini APIでキャッチコピー生成）
 * Phase 6: PostGISを活用したクラスター選定
 */
class GenerateSuggestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public SuggestionSet $suggestionSet
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(
        ClusterSelectorService $clusterSelector,
        TravelTimeCalculatorService $travelTimeCalculator,
        CatchphraseGeneratorService $catchphraseGenerator
    ): void {
        try {
            // ステータス更新: pending → processing_clusters
            $this->suggestionSet->update([
                'status' => SuggestionStatus::ProcessingClusters,
            ]);

            // Phase 2ではsleep不要だが、リアルなデモのため3秒待機
            sleep(3);

            // 出発地から適切なクラスターを選定（Phase 2はダミー: 最初の3件）
            $clusters = $clusterSelector->selectClusters(
                $this->suggestionSet->input_latitude,
                $this->suggestionSet->input_longitude,
                3
            );

            // 見つかったクラスター名を保存
            $clusterNames = $clusters->pluck('name')->toArray();

            // ステータス更新: processing_clusters → analyzing_items
            $this->suggestionSet->update([
                'status' => SuggestionStatus::AnalyzingItems,
                'processing_details' => new ProcessingDetailsData(
                    found_clusters: $clusterNames
                ),
            ]);

            // Phase 2ではsleep不要だが、リアルなデモのため3秒待機
            sleep(3);

            // 各クラスターに対してSuggestionSetItemを作成
            foreach ($clusters as $index => $cluster) {
                // キャッチコピー生成（Phase 2はダミー）
                $catchphrase = $catchphraseGenerator->generateCatchphrase(
                    $cluster,
                    $this->suggestionSet->input_latitude,
                    $this->suggestionSet->input_longitude
                );

                // キービジュアル選定（ランダムに取得）
                $keyVisualImage = Image::inRandomOrder()->first();

                // デフォルトモデルプラン取得
                $defaultModelPlan = $cluster->defaultModelPlan;

                if (!$defaultModelPlan) {
                    Log::warning("Cluster {$cluster->id} has no default model plan");
                    continue;
                }

                // 移動時間計算
                $travelTimeMinutes = $travelTimeCalculator->calculateTravelTime(
                    $this->suggestionSet->input_latitude,
                    $this->suggestionSet->input_longitude,
                    $cluster
                );

                $travelTimeText = $travelTimeCalculator->formatTravelTimeText($travelTimeMinutes);

                // SuggestionSetItem作成
                SuggestionSetItem::create([
                    'suggestion_set_id' => $this->suggestionSet->id,
                    'cluster_id' => $cluster->id,
                    'key_visual_image_id' => $keyVisualImage->id,
                    'catchphrase_id' => $catchphrase->id,
                    'model_plan_id' => $defaultModelPlan->id,
                    'display_order' => $index + 1,
                    'generated_travel_time_text' => $travelTimeText,
                ]);
            }

            // ステータス更新: analyzing_items → complete
            $this->suggestionSet->update([
                'status' => SuggestionStatus::Complete,
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

            Log::error('GenerateSuggestionsJob failed', [
                'suggestion_set_id' => $this->suggestionSet->id,
                'error' => $e->getMessage(),
            ]);

            // ジョブを失敗させる
            $this->fail($e);
        }
    }
}
