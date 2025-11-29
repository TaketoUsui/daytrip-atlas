<?php

namespace App\Jobs\Analysis;

use App\Exceptions\ConcurrentAnalysisException;
use App\Models\AiModel;
use App\Models\AiModelExecutionLog;
use App\Models\Cluster;
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
 * スポット優先度付けジョブ（Aタイプタスク）
 *
 * クラスター内のスポットに分析優先度（1-3）を付与する
 * - 3: 隠れ観光スポット（最優先）
 * - 2: 定番観光スポット
 * - 1: 散歩スポット
 */
class AnalyzeSpotPriorityJob implements ShouldQueue
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
            Log::info('[AnalyzeSpotPriorityJob] Starting', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'model' => $this->model->model_name,
            ]);
        }

        try {
            // ロックを取得
            $lockManager->acquireLock($this->cluster, 'spot_priority', $this->model);

            if ($debugLog) {
                Log::info('[AnalyzeSpotPriorityJob] Lock acquired', [
                    'cluster_id' => $this->cluster->id,
                ]);
            }

            // クラスターに属するスポットを取得（analysis_failedを除外）
            $spots = $this->cluster->validSpots;

            if ($spots->isEmpty()) {
                throw new Exception('No valid spots found for cluster');
            }

            // スポット名のリストを作成
            $spotNames = $spots->pluck('name')->toArray();

            // プロンプトを読み込み
            $prompt = $promptLoader->load('spot_priority_analysis.txt', [
                'cluster_name' => $this->cluster->name,
                'spot_names' => implode("\n", $spotNames),
            ]);

            // API呼び出し時刻を記録（実際の呼び出し直前）
            $apiCallTime = now();

            // Gemini APIでスポット優先度を取得
            $response = $geminiClient->generateContent(
                $prompt,
                model: $this->model->model_name
            );

            // JSONレスポンスをパース
            $data = $geminiClient->parseJsonResponse($response);

            if (! isset($data['priorities']) || ! is_array($data['priorities'])) {
                throw new Exception('Invalid response format: missing "priorities" array');
            }

            // スポットに優先度を設定
            $this->assignPriorities($spots, $data['priorities']);

            // ロックを解放（分析完了）
            $lockManager->releaseLock($this->cluster, 'spot_priority', $this->model);

            // API呼び出し成功フラグを立てる
            $apiCallSuccess = true;

            Log::info('[AnalyzeSpotPriorityJob] Successfully assigned priorities', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'spots_count' => $spots->count(),
                'model' => $this->model->model_name,
            ]);

        } catch (ConcurrentAnalysisException $e) {
            // 並行実行が検出された場合はジョブを終了（リトライしない）
            Log::info('[AnalyzeSpotPriorityJob] Concurrent execution detected, skipping', [
                'cluster_id' => $this->cluster->id,
                'error' => $e->getMessage(),
            ]);

            return;

        } catch (Exception $e) {
            Log::error('[AnalyzeSpotPriorityJob] Failed to assign priorities', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'error' => $e->getMessage(),
            ]);

            // エラー時はロックを強制解放
            $lockManager->forceReleaseLock($this->cluster, 'spot_priority');

            throw $e;

        } finally {
            // API呼び出しの実行ログを記録（成功・失敗を問わず）
            if ($apiCallTime) {
                AiModelExecutionLog::create([
                    'ai_model_id' => $this->model->id,
                    'executed_at' => $apiCallTime,
                    'task_type' => 'spot_priority',
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

    /**
     * スポットに優先度を設定
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $spots
     * @param  array<int, array{name: string, priority: int}>  $priorities
     */
    private function assignPriorities($spots, array $priorities): void
    {
        // 名前→優先度のマップを作成
        $priorityMap = [];
        foreach ($priorities as $item) {
            if (isset($item['name']) && isset($item['priority'])) {
                $priorityMap[$item['name']] = $item['priority'];
            }
        }

        // 各スポットに優先度を設定
        foreach ($spots as $spot) {
            $priority = $priorityMap[$spot->name] ?? 1; // デフォルトは1（散歩スポット）

            // 優先度の範囲チェック（1-3）
            $priority = max(1, min(3, $priority));

            $spot->update([
                'analysis_priority' => $priority,
            ]);

            Log::info('[AnalyzeSpotPriorityJob] Assigned priority', [
                'spot_id' => $spot->id,
                'spot_name' => $spot->name,
                'priority' => $priority,
            ]);
        }
    }
}
