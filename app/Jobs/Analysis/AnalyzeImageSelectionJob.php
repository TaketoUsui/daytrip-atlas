<?php

namespace App\Jobs\Analysis;

use App\Exceptions\ConcurrentAnalysisException;
use App\Models\AiModel;
use App\Models\Cluster;
use App\Models\Image;
use App\Services\AI\LockManager;
use App\Services\GeminiClientService;
use App\Services\PromptLoaderService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * 画像選定ジョブ（Bタイプタスク）
 *
 * クラスターに最適な画像を選定し、全モデルプランに設定する
 */
class AnalyzeImageSelectionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** ジョブのタイムアウト時間（秒） */
    public int $timeout = 180;

    /** 最大リトライ回数 */
    public int $tries;

    /** リトライ間隔（秒） */
    public int $backoff;

    public function __construct(
        public Cluster $cluster,
        public AiModel $model
    ) {
        $this->tries = config('ai.retry.max_attempts', 3);
        $this->backoff = config('ai.retry.backoff_seconds', 60);
    }

    /**
     * ジョブの実行
     */
    public function handle(
        LockManager $lockManager,
        PromptLoaderService $promptLoader,
        GeminiClientService $geminiClient
    ): void {
        $debugLog = config('ai.debug.log_job_execution', false);

        if ($debugLog) {
            Log::info('[AnalyzeImageSelectionJob] Starting', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'model' => $this->model->model_name,
            ]);
        }

        try {
            // ロックを取得
            $lockManager->acquireLock($this->cluster, 'image', $this->model);

            if ($debugLog) {
                Log::info('[AnalyzeImageSelectionJob] Lock acquired', [
                    'cluster_id' => $this->cluster->id,
                ]);
            }

            // 利用可能な画像リストを取得
            $availableImages = Image::all();

            if ($availableImages->isEmpty()) {
                throw new Exception('No available images found');
            }

            // メインスポット情報を取得
            $mainSpotName = null;
            $mainSpotRole = null;

            $modelPlans = $this->cluster->modelPlans;
            if ($modelPlans->isNotEmpty()) {
                $firstPlan = $modelPlans->first();
                if ($firstPlan->mainSpot) {
                    $mainSpotName = $firstPlan->mainSpot->name;
                    $mainSpotRole = $firstPlan->mainSpot->spot_role;
                }
            }

            // 画像リストをフォーマット
            $imageListText = $this->formatImageList($availableImages);

            // プロンプトを読み込み
            $prompt = $promptLoader->load('image_selection.txt', [
                'cluster_name' => $this->cluster->name,
                'main_spot_name' => $mainSpotName ?? 'なし',
                'main_spot_role' => $mainSpotRole ?? 'unknown',
                'available_images' => $imageListText,
            ]);

            // Gemini APIで画像を選択
            $response = $geminiClient->generateContent(
                $prompt,
                model: $this->model->model_name
            );

            // JSONレスポンスをパース
            $data = $geminiClient->parseJsonResponse($response);

            if (! isset($data['selected_image_id'])) {
                throw new Exception('Invalid response format: missing "selected_image_id"');
            }

            $selectedImageId = $data['selected_image_id'];

            // 画像を取得
            $selectedImage = Image::find($selectedImageId);

            if (! $selectedImage) {
                throw new Exception("Selected image not found: {$selectedImageId}");
            }

            // クラスターの全モデルプランに画像を設定
            foreach ($modelPlans as $modelPlan) {
                $modelPlan->update([
                    'image_id' => $selectedImageId,
                ]);

                Log::info('[AnalyzeImageSelectionJob] Updated model plan with image', [
                    'model_plan_id' => $modelPlan->id,
                    'image_id' => $selectedImageId,
                ]);
            }

            // ロックを解放（分析完了）
            $lockManager->releaseLock($this->cluster, 'image', $this->model);

            Log::info('[AnalyzeImageSelectionJob] Successfully selected image', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'image_id' => $selectedImageId,
                'updated_model_plans' => $modelPlans->count(),
                'model' => $this->model->model_name,
            ]);

        } catch (ConcurrentAnalysisException $e) {
            // 並行実行が検出された場合はジョブを終了（リトライしない）
            Log::info('[AnalyzeImageSelectionJob] Concurrent execution detected, skipping', [
                'cluster_id' => $this->cluster->id,
                'error' => $e->getMessage(),
            ]);

            return;

        } catch (Exception $e) {
            Log::error('[AnalyzeImageSelectionJob] Failed to select image', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'error' => $e->getMessage(),
            ]);

            // エラー時はロックを強制解放
            $lockManager->forceReleaseLock($this->cluster, 'image');

            throw $e;
        }
    }

    /**
     * 画像リストをテキスト形式にフォーマット
     *
     * @param  \Illuminate\Database\Eloquent\Collection<int, Image>  $images  画像コレクション
     * @return string フォーマットされた画像リスト
     */
    private function formatImageList($images): string
    {
        $lines = [];

        foreach ($images as $image) {
            $parts = [
                sprintf('ID: %d', $image->id),
            ];

            // alt_text（画像の種類を示す主要な情報）
            if ($image->alt_text) {
                $parts[] = sprintf('種類: %s', $image->alt_text);
            }

            // description（画像の詳細説明）
            if ($image->description) {
                $parts[] = sprintf('説明: %s', $image->description);
            }

            // file_name（ファイル名も参考情報として）
            if ($image->file_name) {
                $parts[] = sprintf('ファイル名: %s', $image->file_name);
            }

            // category（設定されている場合のみ）
            if ($image->category) {
                $parts[] = sprintf('カテゴリ: %s', $image->category);
            }

            $lines[] = implode(' | ', $parts);
        }

        return implode("\n", $lines);
    }
}
