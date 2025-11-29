<?php

namespace App\Jobs\Analysis;

use App\Exceptions\ConcurrentAnalysisException;
use App\Models\AiModel;
use App\Models\ModelPlan;
use App\Models\ModelPlanItem;
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
 * モデルプラン生成ジョブ（Bタイプタスク）
 *
 * キャッチフレーズをもとに、モデルプランの詳細（訪問順序、滞在時間など）を生成する
 */
class AnalyzeModelPlanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** ジョブのタイムアウト時間（秒） */
    public int $timeout = 180;

    /** 最大リトライ回数 */
    public int $tries;

    /** リトライ間隔（秒） */
    public int $backoff;

    public function __construct(
        public ModelPlan $modelPlan,
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
            Log::info('[AnalyzeModelPlanJob] Starting', [
                'model_plan_id' => $this->modelPlan->id,
                'cluster_id' => $this->modelPlan->cluster_id,
                'model' => $this->model->model_name,
            ]);
        }

        try {
            // ロックを取得
            $lockManager->acquireLock($this->modelPlan, 'model_plan', $this->model);

            if ($debugLog) {
                Log::info('[AnalyzeModelPlanJob] Lock acquired', [
                    'model_plan_id' => $this->modelPlan->id,
                ]);
            }

            // キャッチフレーズを取得
            $catchphrase = $this->modelPlan->catchphrase;
            if (!$catchphrase) {
                throw new Exception('Catchphrase not found for model plan');
            }

            // クラスターに属するスポットを取得（analysis_failedを除外）
            $cluster = $this->modelPlan->cluster;
            $spots = $cluster->validSpots;

            if ($spots->isEmpty()) {
                throw new Exception('No valid spots found for cluster');
            }

            // スポット情報をフォーマット
            $spotsInfo = $spots->map(function ($spot) {
                return [
                    'id' => $spot->id,
                    'name' => $spot->name,
                    'role' => $spot->spot_role,
                    'min_duration_minutes' => $spot->min_duration_minutes,
                    'max_duration_minutes' => $spot->max_duration_minutes,
                ];
            })->toArray();

            // プロンプトを読み込み
            $prompt = $promptLoader->load('model_plan_generation.txt', [
                'cluster_name' => $cluster->name,
                'catchphrase' => $catchphrase->content,
                'spots_json' => json_encode($spotsInfo, JSON_UNESCAPED_UNICODE),
            ]);

            // Gemini APIでモデルプランを生成
            $response = $geminiClient->generateContent(
                $prompt,
                model: $this->model->model_name
            );

            // JSONレスポンスをパース
            $data = $geminiClient->parseJsonResponse($response);

            if (!isset($data['plan_items']) || !is_array($data['plan_items'])) {
                throw new Exception('Invalid response format: missing "plan_items" array');
            }

            // 既存のアイテムを削除
            $this->modelPlan->items()->delete();

            // モデルプランアイテムを作成
            $totalDurationMinutes = 0;
            foreach ($data['plan_items'] as $index => $item) {
                if (!isset($item['spot_id'], $item['duration_minutes'])) {
                    Log::warning('[AnalyzeModelPlanJob] Invalid plan item, skipping', [
                        'index' => $index,
                        'item' => $item,
                    ]);
                    continue;
                }

                ModelPlanItem::create([
                    'model_plan_id' => $this->modelPlan->id,
                    'display_order' => $index + 1,
                    'spot_id' => $item['spot_id'],
                    'duration_minutes' => $item['duration_minutes'],
                    'travel_time_to_next_minutes' => $item['travel_time_to_next_minutes'] ?? 0,
                    'travel_mode' => $item['travel_mode'] ?? null,
                    'description' => $item['description'] ?? null,
                ]);

                $totalDurationMinutes += $item['duration_minutes'];
                $totalDurationMinutes += $item['travel_time_to_next_minutes'] ?? 0;
            }

            // モデルプランの合計時間を更新
            $this->modelPlan->update([
                'total_duration_minutes' => $totalDurationMinutes,
                'description' => $data['description'] ?? null,
            ]);

            // ロックを解放（分析完了）
            $lockManager->releaseLock($this->modelPlan, 'model_plan', $this->model);

            Log::info('[AnalyzeModelPlanJob] Successfully generated model plan', [
                'model_plan_id' => $this->modelPlan->id,
                'cluster_id' => $cluster->id,
                'items_count' => count($data['plan_items']),
                'total_duration_minutes' => $totalDurationMinutes,
                'model' => $this->model->model_name,
            ]);

        } catch (ConcurrentAnalysisException $e) {
            // 並行実行が検出された場合はジョブを終了（リトライしない）
            Log::info('[AnalyzeModelPlanJob] Concurrent execution detected, skipping', [
                'model_plan_id' => $this->modelPlan->id,
                'error' => $e->getMessage(),
            ]);

            return;

        } catch (Exception $e) {
            Log::error('[AnalyzeModelPlanJob] Failed to generate model plan', [
                'model_plan_id' => $this->modelPlan->id,
                'cluster_id' => $this->modelPlan->cluster_id,
                'error' => $e->getMessage(),
            ]);

            // エラー時はロックを強制解放
            $lockManager->forceReleaseLock($this->modelPlan, 'model_plan');

            throw $e;
        }
    }
}
