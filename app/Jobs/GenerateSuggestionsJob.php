<?php

namespace App\Jobs;

use App\Enums\SuggestionStatus;
use App\Models\SuggestionSet;
use App\Services\ClusterSelectionService;
use App\Services\SuggestionContentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class GenerateSuggestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * ジョブがタイムアウトするまでの秒数
     * AI APIの呼び出しが複数回発生するため、長めに設定 (5分)
     */
    public int $timeout = 300;

    /**
     * ジョブが失敗としてマークされるまでに試行する回数
     * AIの不調を考慮し、リトライは1回のみとする
     */
    public int $tries = 1;

    public function __construct(
        public SuggestionSet $suggestionSet,
    ){}

    /**
     * 提案生成ジョブの本体（オーケストレーター）
     *
     * @param ClusterSelectionService $clusterSelectionService
     * @param SuggestionContentService $suggestionContentService
     * @return void
     * @see MVP_旅先提案アルゴリズム設計 A. ジョブ
     */
    public function handle(
        ClusterSelectionService $clusterSelectionService,
        SuggestionContentService $suggestionContentService
    ): void {
        //
        DB::beginTransaction();

        try {
            // Step 1: ステータス更新（クラスター選定中）
            $this->suggestionSet->update(['status' => SuggestionStatus::ProcessingClusters]);

            // Step 2: クラスターの選定
            $selectedClusters = $clusterSelectionService->selectClusters($this->suggestionSet);

            if ($selectedClusters->isEmpty()) {
                Log::warning("[GenerateSuggestionsJob] No clusters found.", [
                    'suggestion_set_id' => $this->suggestionSet->id
                ]);
                // 提案が0件でもジョブは「完了」
                $this->suggestionSet->update(['status' => SuggestionStatus::Complete]);
                DB::commit();
                return;
            }

            // Step 3: ステータス更新（コンテンツ分析中）
            $this->suggestionSet->update(['status' => SuggestionStatus::AnalyzingItems]);

            // Step 4: コンテンツの動的生成ループ
            foreach ($selectedClusters as $index => $cluster) {
                // SuggestionContentServiceを呼び出し、必要なID群 (DTO) を取得
                $contentDto = $suggestionContentService->generateContentForCluster(
                    $cluster,
                    $this->suggestionSet
                );

                // Step 5: 提案アイテム (suggestion_set_items) をDBに保存
                $this->suggestionSet->items()->create([
                    // 'uuid' は Model boot() で自動生成される
                    'cluster_id' => $contentDto->clusterId,
                    'key_visual_image_id' => $contentDto->keyVisualImageId,
                    'catchphrase_id' => $contentDto->catchphraseId,
                    'model_plan_id' => $contentDto->modelPlanId,
                    'display_order' => $index + 1, // 1-based index
                    // TODO: 本来は出発地とクラスターの距離から移動時間を計算すべき
                    'generated_travel_time_text' => '車で約1時間30分',
                ]);
            }

            // Step 6: 完了ステータスに更新
            $this->suggestionSet->update(['status' => SuggestionStatus::Complete]);

            DB::commit();

        } catch (Throwable $e) {
            //
            DB::rollBack();

            Log::error("Suggestion generation failed", [
                "suggestion_set_id" => $this->suggestionSet->id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
            ]);

            // ステータスを「失敗」に更新
            $this->suggestionSet->update(['status' => SuggestionStatus::Failed]);

            // ジョブを明示的に失敗させ、failed_jobsテーブルに記録
            $this->fail($e);
        }
    }
}
