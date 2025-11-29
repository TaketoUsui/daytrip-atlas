<?php

namespace App\Jobs\Analysis;

use App\Exceptions\ConcurrentAnalysisException;
use App\Models\AiModel;
use App\Models\AiModelExecutionLog;
use App\Models\Catchphrase;
use App\Models\Cluster;
use App\Models\ModelPlan;
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
 * キャッチフレーズ生成ジョブ（Bタイプタスク）
 *
 * クラスターに所属するスポットをもとに、旅行プランのキャッチフレーズを生成する
 */
class AnalyzeCatchphraseJob implements ShouldQueue
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
            Log::info('[AnalyzeCatchphraseJob] Starting', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'model' => $this->model->model_name,
            ]);
        }

        try {
            // モデルプランに対するロックを取得（クラスター経由）
            // 注: ロックの対象はクラスターだが、実際の処理はモデルプランに対して行う
            $modelPlan = $this->ensureModelPlanExists();

            // ロックを取得
            $lockManager->acquireLock($modelPlan, 'catchphrase', $this->model);

            if ($debugLog) {
                Log::info('[AnalyzeCatchphraseJob] Lock acquired', [
                    'cluster_id' => $this->cluster->id,
                    'model_plan_id' => $modelPlan->id,
                ]);
            }

            // モデルプランをリセット（既存の関連データを削除）
            $this->resetModelPlan($modelPlan);

            // クラスターに属するスポットを取得（analysis_failedを除外）
            $spots = $this->cluster->validSpots;

            if ($spots->isEmpty()) {
                throw new Exception('No valid spots found for cluster');
            }

            // スポット名のリストを作成
            $spotNames = $spots->pluck('name')->toArray();

            // プロンプトを読み込み
            $prompt = $promptLoader->load('catchphrase_generation.txt', [
                'cluster_name' => $this->cluster->name,
                'spot_names' => implode("\n", $spotNames),
            ]);

            // API呼び出し時刻を記録（実際の呼び出し直前）
            $apiCallTime = now();

            // Gemini APIでキャッチフレーズを生成
            $response = $geminiClient->generateContent(
                $prompt,
                model: $this->model->model_name
            );

            // JSONレスポンスをパース
            $data = $geminiClient->parseJsonResponse($response);

            if (!isset($data['catchphrase'])) {
                throw new Exception('Invalid response format: missing "catchphrase"');
            }

            $catchphraseText = $data['catchphrase'];

            // キャッチフレーズレコードを作成
            $catchphrase = Catchphrase::create([
                'model_plan_id' => $modelPlan->id,
                'content' => $catchphraseText,
                'source_analysis' => $data['source_analysis'] ?? null,
                'performance_score' => 0, // 初期値
            ]);

            // ロックを解放（分析完了）
            $lockManager->releaseLock($modelPlan, 'catchphrase', $this->model);

            // API呼び出し成功フラグを立てる
            $apiCallSuccess = true;

            Log::info('[AnalyzeCatchphraseJob] Successfully generated catchphrase', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'model_plan_id' => $modelPlan->id,
                'catchphrase_id' => $catchphrase->id,
                'catchphrase' => $catchphraseText,
                'model' => $this->model->model_name,
            ]);

        } catch (ConcurrentAnalysisException $e) {
            // 並行実行が検出された場合はジョブを終了（リトライしない）
            Log::info('[AnalyzeCatchphraseJob] Concurrent execution detected, skipping', [
                'cluster_id' => $this->cluster->id,
                'error' => $e->getMessage(),
            ]);

            return;

        } catch (Exception $e) {
            Log::error('[AnalyzeCatchphraseJob] Failed to generate catchphrase', [
                'cluster_id' => $this->cluster->id,
                'cluster_name' => $this->cluster->name,
                'error' => $e->getMessage(),
            ]);

            // エラー時はロックを強制解放
            if (isset($modelPlan)) {
                $lockManager->forceReleaseLock($modelPlan, 'catchphrase');
            }

            throw $e;

        } finally {
            // API呼び出しの実行ログを記録（成功・失敗を問わず）
            if ($apiCallTime && isset($modelPlan)) {
                AiModelExecutionLog::create([
                    'ai_model_id' => $this->model->id,
                    'executed_at' => $apiCallTime,
                    'task_type' => 'catchphrase',
                    'status' => $apiCallSuccess ? 'success' : 'failed',
                    'target_type' => ModelPlan::class,
                    'target_id' => $modelPlan->id,
                    'metadata' => [
                        'cluster_name' => $this->cluster->name,
                        'model_name' => $this->model->model_name,
                    ],
                ]);
            }
        }
    }

    /**
     * モデルプランの存在を確認し、なければ作成する
     */
    private function ensureModelPlanExists(): ModelPlan
    {
        // クラスターのモデルプランを取得（なければ作成）
        $modelPlan = $this->cluster->modelPlans()->first();

        if (!$modelPlan) {
            $modelPlan = ModelPlan::create([
                'cluster_id' => $this->cluster->id,
                'name' => $this->cluster->name . 'の日帰り旅行',
                'description' => null,
                'total_duration_minutes' => 0,
                'is_default' => true,
            ]);

            Log::info('[AnalyzeCatchphraseJob] Created new model plan', [
                'cluster_id' => $this->cluster->id,
                'model_plan_id' => $modelPlan->id,
            ]);
        }

        return $modelPlan;
    }

    /**
     * モデルプランをリセット（既存の関連データを削除）
     */
    private function resetModelPlan(ModelPlan $modelPlan): void
    {
        // 既存のキャッチフレーズを削除
        $modelPlan->catchphrase()?->delete();

        // model_plan_itemsを削除
        $modelPlan->items()->delete();

        // 画像との関連を解除
        $modelPlan->update([
            'image_id' => null,
            'main_spot_id' => null,
        ]);

        Log::info('[AnalyzeCatchphraseJob] Reset model plan', [
            'model_plan_id' => $modelPlan->id,
        ]);
    }
}
