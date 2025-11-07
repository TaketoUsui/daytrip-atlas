<?php

namespace App\Jobs;

use App\Enums\SuggestionStatus;
use App\Models\SuggestionSet;
use App\Models\Tag;
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
        // [変更] トランザクションはまだ開始しない
        // [!code --] DB::beginTransaction();

        try {
            // Step 1: ステータス更新（クラスター選定中）
            // [変更] この更新を即時コミットするため、トランザクションの外で実行 [!code ++]
            $tagIds = $this->suggestionSet->input_tags_json ?? [];
            $tagsMessage = "提案のリクエストを受け付けました...";
            if (!empty($tagIds)) {
                $tagNames = Tag::whereIn('id', $tagIds)->pluck('name')->implode('」「');
                $tagsMessage = "「{$tagNames}」のテーマを検出しました。";
            }

            $this->suggestionSet->update([
                'status' => SuggestionStatus::ProcessingClusters,
                'processing_details' => ['message' => $tagsMessage . ' あなたに合いそうな観光地を探しています...']
            ]);

            // Step 2: クラスターの選定 (DB読み取りのみなのでトランザクション不要)
            $selectedClusters = $clusterSelectionService->selectClusters($this->suggestionSet);

            if ($selectedClusters->isEmpty()) {
                Log::warning("[GenerateSuggestionsJob] No clusters found.", [
                    'suggestion_set_id' => $this->suggestionSet->id
                ]);
                // 提案が0件でもジョブは「完了」
                $this->suggestionSet->update([
                    'status' => SuggestionStatus::Complete,
                    'processing_details' => null // 完了時はクリア
                ]);
                // [!code --] DB::commit();
                return;
            }

            // Step 3: ステータス更新（コンテンツ分析中）
            // [変更] この更新も即時コミットするため、トランザクションの外で実行 [!code ++]
            $clusterNames = $selectedClusters->pluck('name')[0];
            $this->suggestionSet->update([
                'status' => SuggestionStatus::AnalyzingItems,
                'processing_details' => ['message' => "「{$clusterNames}」など、注目のエリアが見つかりました。おすすめのプランを組み立てています..."]
            ]);

            // [変更] ここからコンテンツ作成（書き込み）が始まるため、トランザクションを開始 [!code ++]
            DB::beginTransaction(); // [!code ++]

            // Step 4: コンテンツの動的生成ループ
            foreach ($selectedClusters as $index => $cluster) {
                // SuggestionContentServiceを呼び出し、必要なID群 (DTO) を取得
                $contentDto = $suggestionContentService->generateContentForCluster(
                    $cluster,
                    $this->suggestionSet
                );

                // Step 5: 提案アイテム (suggestion_set_items) をDBに保存
                // [変更] この create 処理はトランザクション内で実行される [!code ++]
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

            DB::commit(); // [!code ++]

            // Step 6: 完了ステータスに更新
            // [変更] コミットが成功した後、最終ステータスを即時更新 [!code ++]
            $this->suggestionSet->update([
                'status' => SuggestionStatus::Complete,
                'processing_details' => null // 完了時はクリア
            ]);

            // [!code --] DB::commit();

        } catch (Throwable $e) {
            // [変更] トランザクションが開始された後（Step 4以降）で失敗した場合にのみロールバック [!code ++]
            if (DB::transactionLevel() > 0) { // [!code ++]
                DB::rollBack(); // [!code ++]
            } // [!code ++]

            Log::error("Suggestion generation failed", [
                "suggestion_set_id" => $this->suggestionSet->id,
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
            ]);

            // ステータスを「失敗」に更新
            $this->suggestionSet->update([
                'status' => SuggestionStatus::Failed,
                'processing_details' => ['message' => 'エラーが発生しました: ' . $e->getMessage()]
            ]);

            // ジョブを明示的に失敗させ、failed_jobsテーブルに記録
            $this->fail($e);
        }
    }
}
