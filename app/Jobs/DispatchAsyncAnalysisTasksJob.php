<?php

namespace App\Jobs;

use App\Jobs\Analysis\AnalyzeCatchphraseJob;
use App\Jobs\Analysis\AnalyzeImageSelectionJob;
use App\Jobs\Analysis\AnalyzeMainSpotJob;
use App\Jobs\Analysis\AnalyzeModelPlanJob;
use App\Jobs\Analysis\AnalyzeSpotDetailJob;
use App\Jobs\Analysis\AnalyzeSpotListingJob;
use App\Jobs\Analysis\AnalyzeSpotPriorityJob;
use App\Services\AI\TaskSelector;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * 非同期分析タスクディスパッチャージョブ
 *
 * AタイプとBタイプのタスクを選定し、適切なジョブをディスパッチする
 */
class DispatchAsyncAnalysisTasksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** ジョブのタイムアウト時間（秒） */
    public int $timeout = 60;

    /** 最大リトライ回数 */
    public int $tries = 1;

    /**
     * ジョブの実行
     */
    public function handle(TaskSelector $taskSelector): void
    {
        $debugLog = config('ai.debug.log_task_selection', false);

        // AI非同期分析が有効かチェック
        if (! config('ai.async_analysis_enabled', true)) {
            if ($debugLog) {
                Log::info('[DispatchAsyncAnalysisTasksJob] AI async analysis is disabled');
            }

            return;
        }

        try {
            // 使用可能なAIモデルを選定
            $model = $taskSelector->selectAvailableModel();

            if (! $model) {
                if ($debugLog) {
                    Log::info('[DispatchAsyncAnalysisTasksJob] No available AI model at this time');
                }

                return;
            }

            // AタイプとBタイプのどちらを優先するか決定
            $taskType = $taskSelector->selectTaskType();

            if ($debugLog) {
                Log::info('[DispatchAsyncAnalysisTasksJob] Task type selected', [
                    'task_type' => $taskType,
                    'model' => $model->model_name,
                ]);
            }

            $dispatched = false;

            // 選択されたタイプを試す
            if ($taskType === 'a_type') {
                $dispatched = $this->dispatchATypeTask($taskSelector, $model);
            } else {
                $dispatched = $this->dispatchBTypeTask($taskSelector, $model);
            }

            // 選択されたタイプでタスクが見つからなかった場合、もう一方を試す
            if (! $dispatched) {
                if ($debugLog) {
                    Log::info('[DispatchAsyncAnalysisTasksJob] No tasks found for selected type, trying alternative', [
                        'tried_type' => $taskType,
                        'alternative_type' => $taskType === 'a_type' ? 'b_type' : 'a_type',
                    ]);
                }

                if ($taskType === 'a_type') {
                    $this->dispatchBTypeTask($taskSelector, $model);
                } else {
                    $this->dispatchATypeTask($taskSelector, $model);
                }
            }

        } catch (Exception $e) {
            Log::error('[DispatchAsyncAnalysisTasksJob] Failed to dispatch tasks', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Aタイプタスク（スポット関連分析）をディスパッチ
     *
     * @return bool タスクをディスパッチした場合true
     */
    private function dispatchATypeTask(TaskSelector $taskSelector, $model): bool
    {
        $debugLog = config('ai.debug.log_task_selection', false);

        $task = $taskSelector->selectATypeTask();

        if (! $task) {
            if ($debugLog) {
                Log::info('[DispatchAsyncAnalysisTasksJob] No A-type tasks available');
            }

            return false;
        }

        $taskType = $task['type'];

        // タスクタイプに応じた適切なジョブをディスパッチ
        match ($taskType) {
            'spot_detail' => AnalyzeSpotDetailJob::dispatch($task['spot'], $model),
            'spot_priority' => AnalyzeSpotPriorityJob::dispatch($task['cluster'], $model),
            'spot_listing' => AnalyzeSpotListingJob::dispatch($task['cluster'], $model),
            default => throw new Exception("Unknown A-type task: {$taskType}"),
        };

        $targetId = isset($task['spot']) ? $task['spot']->id : $task['cluster']->id;
        $targetName = isset($task['spot']) ? $task['spot']->name : $task['cluster']->name;

        Log::info('[DispatchAsyncAnalysisTasksJob] Dispatched A-type task', [
            'task_type' => $taskType,
            'target_id' => $targetId,
            'target_name' => $targetName,
            'model' => $model->model_name,
        ]);

        return true;
    }

    /**
     * Bタイプタスク（クラスター関連分析）をディスパッチ
     *
     * @return bool タスクをディスパッチした場合true
     */
    private function dispatchBTypeTask(TaskSelector $taskSelector, $model): bool
    {
        $debugLog = config('ai.debug.log_task_selection', false);

        $task = $taskSelector->selectBTypeTask();

        if (! $task) {
            if ($debugLog) {
                Log::info('[DispatchAsyncAnalysisTasksJob] No B-type tasks available');
            }

            return false;
        }

        $taskType = $task['type'];

        // タスクタイプに応じた適切なジョブをディスパッチ
        match ($taskType) {
            'image_selection' => AnalyzeImageSelectionJob::dispatch($task['model_plan'], $model),
            'main_spot' => AnalyzeMainSpotJob::dispatch($task['cluster'], $model),
            'model_plan' => AnalyzeModelPlanJob::dispatch($task['model_plan'], $model),
            'catchphrase' => AnalyzeCatchphraseJob::dispatch($task['cluster'], $model),
            default => throw new Exception("Unknown B-type task: {$taskType}"),
        };

        $targetId = isset($task['cluster']) ? $task['cluster']->id : $task['model_plan']->id;
        $targetName = isset($task['cluster']) ? $task['cluster']->name : $task['model_plan']->name;

        Log::info('[DispatchAsyncAnalysisTasksJob] Dispatched B-type task', [
            'task_type' => $taskType,
            'target_id' => $targetId,
            'target_name' => $targetName,
            'model' => $model->model_name,
        ]);

        return true;
    }
}
