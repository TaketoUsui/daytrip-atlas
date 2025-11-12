<?php

namespace App\Jobs;

use App\Data\ProcessingDetailsData;
use App\Enums\SuggestionStatus;
use App\Models\Image;
use App\Models\SuggestionSet;
use App\Models\SuggestionSetItem;
use App\Services\CatchphraseGeneratorService;
use App\Services\ClusterEvaluatorService;
use App\Services\ClusterSelectorService;
use App\Services\ImageSelectorService;
use App\Services\ModelPlanGeneratorService;
use App\Services\SpotDetailAnalyzerService;
use App\Services\SpotListingService;
use App\Services\TravelTimeCalculatorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * 旅行提案自動生成ジョブ
 *
 * AI（Gemini API）を使用して、クラスターからスポット、プラン、キャッチコピーまで
 * 全てを自動生成する7段階のパイプライン処理
 *
 * 処理フロー:
 * 1. クラスター選定（確率的重みづけ）
 * 2. Spotsリストアップ（gemini-2.5-flash）
 * 3. Spots詳細分析（gemini-2.5-flash-lite + 座標検証）
 * 4. キャッチコピー生成（gemini-2.5-flash）
 * 5. 画像選択（gemini-2.5-flash-lite）
 * 6. モデルプラン生成（gemini-2.5-flash）
 * 7. Cluster再評価
 */
class GenerateSuggestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** ジョブのタイムアウト時間（秒） */
    public int $timeout = 300;

    public function __construct(
        public SuggestionSet $suggestionSet
    ) {}

    /**
     * ジョブの実行
     */
    public function handle(
        ClusterSelectorService $clusterSelector,
        SpotListingService $spotListing,
        SpotDetailAnalyzerService $spotAnalyzer,
        CatchphraseGeneratorService $catchphraseGenerator,
        ImageSelectorService $imageSelector,
        ModelPlanGeneratorService $modelPlanGenerator,
        ClusterEvaluatorService $clusterEvaluator,
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
                throw new \Exception('No suitable clusters found');
            }

            $clusterNames = $clusters->pluck('name')->toArray();
            $this->suggestionSet->update([
                'processing_details' => new ProcessingDetailsData(
                    found_clusters: $clusterNames
                ),
            ]);

            Log::info('Clusters selected', [
                'suggestion_set_id' => $this->suggestionSet->id,
                'clusters' => $clusterNames,
            ]);

            // Step 2: Spotsリストアップ
            $this->suggestionSet->update([
                'status' => SuggestionStatus::ListingSpots,
            ]);

            foreach ($clusters as $cluster) {
                try {
                    $spots = $spotListing->listSpots($cluster);
                    Log::info('Spots listed for cluster', [
                        'cluster_id' => $cluster->id,
                        'spots_count' => $spots->count(),
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to list spots for cluster', [
                        'cluster_id' => $cluster->id,
                        'error' => $e->getMessage(),
                    ]);
                    // エラーが発生してもジョブは継続（他のクラスターは処理する）
                }
            }

            // Step 3: Spots詳細分析（並列実行）
            $this->suggestionSet->update([
                'status' => SuggestionStatus::AnalyzingSpots,
            ]);

            foreach ($clusters as $cluster) {
                // クラスターに紐づくGeneratingステータスのスポットを取得
                $spotsToAnalyze = $cluster->spots()
                    ->where('spot_role', 'generating')
                    ->get();

                foreach ($spotsToAnalyze as $spot) {
                    try {
                        $spotAnalyzer->analyzeSpot($spot, $cluster);
                    } catch (\Exception $e) {
                        Log::error('Failed to analyze spot', [
                            'spot_id' => $spot->id,
                            'cluster_id' => $cluster->id,
                            'error' => $e->getMessage(),
                        ]);
                        // エラーが発生してもジョブは継続
                    }
                }
            }

            // Step 4: コンテンツ生成（並列実行可能）
            $this->suggestionSet->update([
                'status' => SuggestionStatus::GeneratingContent,
            ]);

            foreach ($clusters as $index => $cluster) {
                try {
                    // キャッチコピー生成
                    $catchphrase = $catchphraseGenerator->generateCatchphrase(
                        $cluster,
                        $this->suggestionSet->input_latitude,
                        $this->suggestionSet->input_longitude
                    );

                    // 画像選択（クラスターの全スポットから選択）
                    $clusterSpots = $cluster->spots()
                        ->whereNotNull('spot_role')
                        ->get();

                    $keyVisualImage = null;
                    if ($clusterSpots->isNotEmpty()) {
                        // 最初のメインスポットの画像を選択
                        $mainSpot = $clusterSpots->where('spot_role', 'main_destination')->first()
                            ?? $clusterSpots->first();

                        $keyVisualImage = $imageSelector->selectImageForSpot($mainSpot);
                    }

                    // フォールバック: 画像が選択できなかった場合はランダム
                    if (! $keyVisualImage) {
                        $keyVisualImage = Image::inRandomOrder()->first();
                    }

                    // モデルプラン生成
                    $travelTimeMinutes = $travelTimeCalculator->calculateTravelTime(
                        $this->suggestionSet->input_latitude,
                        $this->suggestionSet->input_longitude,
                        $cluster
                    );
                    $travelTimeText = $travelTimeCalculator->formatTravelTimeText($travelTimeMinutes);

                    $modelPlan = $modelPlanGenerator->generateModelPlan($cluster, $travelTimeText);

                    // モデルプランが生成できなかった場合はこのクラスターをスキップ
                    if (! $modelPlan) {
                        Log::warning('Skipping cluster due to model plan generation failure', [
                            'cluster_id' => $cluster->id,
                        ]);

                        continue;
                    }

                    // SuggestionSetItem作成
                    SuggestionSetItem::create([
                        'suggestion_set_id' => $this->suggestionSet->id,
                        'cluster_id' => $cluster->id,
                        'key_visual_image_id' => $keyVisualImage->id,
                        'catchphrase_id' => $catchphrase->id,
                        'model_plan_id' => $modelPlan->id,
                        'display_order' => $index + 1,
                        'generated_travel_time_text' => $travelTimeText,
                    ]);

                    Log::info('Suggestion item created', [
                        'cluster_id' => $cluster->id,
                        'model_plan_id' => $modelPlan->id,
                    ]);

                } catch (\Exception $e) {
                    Log::error('Failed to generate content for cluster', [
                        'cluster_id' => $cluster->id,
                        'error' => $e->getMessage(),
                    ]);
                    // エラーが発生してもジョブは継続
                }
            }

            // Step 5: Cluster再評価
            $this->suggestionSet->update([
                'status' => SuggestionStatus::EvaluatingClusters,
            ]);

            $clusterEvaluator->evaluateClusters($clusters);

            // Step 6: 完了
            $this->suggestionSet->update([
                'status' => SuggestionStatus::Complete,
            ]);

            Log::info('Suggestion generation completed', [
                'suggestion_set_id' => $this->suggestionSet->id,
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
                'trace' => $e->getTraceAsString(),
            ]);

            // ジョブを失敗させる
            $this->fail($e);
        }
    }
}
