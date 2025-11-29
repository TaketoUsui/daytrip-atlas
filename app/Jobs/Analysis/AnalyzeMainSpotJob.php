<?php

namespace App\Jobs\Analysis;

use App\Exceptions\ConcurrentAnalysisException;
use App\Models\AiModel;
use App\Models\AiModelExecutionLog;
use App\Models\Cluster;
use App\Models\Spot;
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
 * メインスポット選定ジョブ（Bタイプタスク）
 *
 * クラスターのメインスポットを選定し、全モデルプランに設定する
 */
class AnalyzeMainSpotJob implements ShouldQueue
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
        $apiCallSuccess = false;
        $apiCallTime = null;

        if ($debugLog) {
            Log::info('[AnalyzeMainSpotJob] Starting', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'model' => $this->model->model_name,
            ]);
        }

        try {
            // ロックを取得
            $lockManager->acquireLock($this->cluster, 'main_spot', $this->model);

            if ($debugLog) {
                Log::info('[AnalyzeMainSpotJob] Lock acquired', [
                    'cluster_id' => $this->cluster->id,
                ]);
            }

            // クラスターに属するスポットを取得（優先度の高い順、analysis_failedを除外）
            $spots = $this->cluster->validSpots()
                ->whereNotNull('analysis_priority')
                ->orderBy('analysis_priority', 'desc')
                ->get();

            if ($spots->isEmpty()) {
                throw new Exception('No valid spots with priority found for cluster');
            }

            // スポット情報をフォーマット
            $spotsInfo = $spots->map(function ($spot) {
                return [
                    'id' => $spot->id,
                    'name' => $spot->name,
                    'priority' => $spot->analysis_priority,
                    'role' => $spot->spot_role,
                ];
            })->toArray();

            // プロンプトを読み込み
            $prompt = $promptLoader->load('main_spot_selection.txt', [
                'cluster_name' => $this->cluster->name,
                'spots_json' => json_encode($spotsInfo, JSON_UNESCAPED_UNICODE),
            ]);

            // API呼び出し時刻を記録（実際の呼び出し直前）
            $apiCallTime = now();

            // Gemini APIでメインスポットを選定
            $response = $geminiClient->generateContent(
                $prompt,
                model: $this->model->model_name
            );

            // JSONレスポンスをパース
            $data = $geminiClient->parseJsonResponse($response);

            if (! isset($data['main_spot_id'])) {
                throw new Exception('Invalid response format: missing "main_spot_id"');
            }

            $mainSpotId = $data['main_spot_id'];

            // 選択されたスポットが存在するか確認
            $mainSpot = Spot::find($mainSpotId);
            if (! $mainSpot) {
                throw new Exception("Selected main spot not found: {$mainSpotId}");
            }

            // クラスターの全モデルプランにメインスポットを設定
            $modelPlans = $this->cluster->modelPlans;
            foreach ($modelPlans as $modelPlan) {
                $modelPlan->update([
                    'main_spot_id' => $mainSpotId,
                ]);

                Log::info('[AnalyzeMainSpotJob] Updated model plan with main spot', [
                    'model_plan_id' => $modelPlan->id,
                    'main_spot_id' => $mainSpotId,
                ]);
            }

            // ロックを解放（分析完了）
            $lockManager->releaseLock($this->cluster, 'main_spot', $this->model);

            // API呼び出し成功フラグを立てる
            $apiCallSuccess = true;

            Log::info('[AnalyzeMainSpotJob] Successfully selected main spot', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'main_spot_id' => $mainSpotId,
                'main_spot_name' => $mainSpot->name,
                'updated_model_plans' => $modelPlans->count(),
                'model' => $this->model->model_name,
            ]);

        } catch (ConcurrentAnalysisException $e) {
            // 並行実行が検出された場合はジョブを終了（リトライしない）
            Log::info('[AnalyzeMainSpotJob] Concurrent execution detected, skipping', [
                'cluster_id' => $this->cluster->id,
                'error' => $e->getMessage(),
            ]);

            return;

        } catch (Exception $e) {
            Log::error('[AnalyzeMainSpotJob] Failed to select main spot', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'error' => $e->getMessage(),
            ]);

            // エラー時はロックを強制解放
            $lockManager->forceReleaseLock($this->cluster, 'main_spot');

            throw $e;

        } finally {
            // API呼び出しの実行ログを記録（成功・失敗を問わず）
            if ($apiCallTime) {
                AiModelExecutionLog::create([
                    'ai_model_id' => $this->model->id,
                    'executed_at' => $apiCallTime,
                    'task_type' => 'main_spot',
                    'status' => $apiCallSuccess ? 'success' : 'failed',
                    'target_type' => Cluster::class,
                    'target_id' => $this->cluster->id,
                    'metadata' => [
                        'cluster_name' => $this->cluster->name,
                        'model_name' => $this->model->model_name,
                    ],
                ]);
            }
        }
    }
}
