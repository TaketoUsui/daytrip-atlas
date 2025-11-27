<?php

namespace App\Services\AI;

use App\Models\AiModel;
use App\Models\Cluster;
use App\Models\Spot;
use Illuminate\Support\Collection;

/**
 * AI分析タスク選定サービス
 *
 * Aタイプ（スポット関連分析）とBタイプ（プラン関連分析）のタスクを選定する
 *
 * Aタイプ（80%）: スポット詳細分析、スポット優先度付け、スポットリストアップ
 * Bタイプ（20%）: 画像選定、メインスポット選定、モデルプラン生成、キャッチフレーズ生成
 */
class TaskSelector
{
    /**
     * Aタイプタスク（スポット関連分析）を選定
     *
     * 優先順位:
     * 1. スポット詳細分析
     * 2. スポット優先度付け
     * 3. スポットリストアップ
     *
     * @return array{type: string, cluster?: Cluster, spot?: Spot}|null
     */
    public function selectATypeTask(): ?array
    {
        $maxConcurrent = config('ai.task_selection.max_concurrent_tasks_per_type', 3);
        $lockTimeoutMinutes = config('ai.task_selection.task_lock_timeout_minutes', 30);

        // Aタイプタスクの優先順位（temp.mdの仕様通り）
        $taskPriorities = [
            'spot_detail',      // 1. スポット詳細分析（最優先）
            'spot_priority',    // 2. スポット優先度付け
            'spot_listing',     // 3. スポットリストアップ
        ];

        foreach ($taskPriorities as $taskType) {
            // このタスク種別で実行中のタスク数を確認
            $runningCount = $this->countRunningTasksForAType($taskType, $lockTimeoutMinutes);

            if ($runningCount >= $maxConcurrent) {
                continue; // このタスク種別はスロットがいっぱい
            }

            // このタスク種別で実行可能なタスクを取得
            $task = $this->findTaskForAType($taskType);

            if ($task) {
                return $task;
            }
        }

        return null;
    }

    /**
     * Aタイプタスクの実行中タスク数をカウント
     */
    private function countRunningTasksForAType(string $taskType, int $lockTimeoutMinutes): int
    {
        if ($taskType === 'spot_detail') {
            return Spot::whereNotNull('detail_analyzing_by_model_id')
                ->where('detail_analyzing_started_at', '>', now()->subMinutes($lockTimeoutMinutes))
                ->count();
        }

        // spot_priority, spot_listingはClusterテーブルで管理
        $analyzingByColumn = "{$taskType}_analyzing_by_model_id";
        $analyzingStartedAtColumn = "{$taskType}_analyzing_started_at";

        return Cluster::whereNotNull($analyzingByColumn)
            ->where($analyzingStartedAtColumn, '>', now()->subMinutes($lockTimeoutMinutes))
            ->count();
    }

    /**
     * Aタイプタスクを検索
     */
    private function findTaskForAType(string $taskType): ?array
    {
        switch ($taskType) {
            case 'spot_detail':
                // スポット詳細分析: 分析優先度が高く、まだ分析されていないスポット
                $spot = Spot::whereNull('detail_analyzed_by_model_id')
                    ->whereNull('detail_analyzing_by_model_id')
                    ->whereNotNull('analysis_priority')
                    ->orderBy('analysis_priority', 'desc')
                    ->inRandomOrder()
                    ->first();

                return $spot ? ['type' => 'spot_detail', 'spot' => $spot] : null;

            case 'spot_priority':
                // スポット優先度付け: スポットリストアップが完了しているクラスター
                $cluster = Cluster::whereNotNull('spot_listing_analyzed_by_model_id')
                    ->whereNull('spot_priority_analyzed_by_model_id')
                    ->whereNull('spot_priority_analyzing_by_model_id')
                    ->inRandomOrder()
                    ->first();

                return $cluster ? ['type' => 'spot_priority', 'cluster' => $cluster] : null;

            case 'spot_listing':
                // スポットリストアップ: まだリストアップされていないクラスター
                $cluster = Cluster::whereNull('spot_listing_analyzed_by_model_id')
                    ->whereNull('spot_listing_analyzing_by_model_id')
                    ->inRandomOrder()
                    ->first();

                return $cluster ? ['type' => 'spot_listing', 'cluster' => $cluster] : null;

            default:
                return null;
        }
    }

    /**
     * Bタイプタスク（プラン関連分析）を選定
     *
     * 優先順位（temp.mdの仕様通り）:
     * 1. 画像選定
     * 2. メインスポット選定
     * 3. モデルプラン生成
     * 4. キャッチフレーズ生成
     *
     * @return array{type: string, cluster?: Cluster, model_plan?: ModelPlan}|null
     */
    public function selectBTypeTask(): ?array
    {
        $maxConcurrent = config('ai.task_selection.max_concurrent_tasks_per_type', 3);
        $lockTimeoutMinutes = config('ai.task_selection.task_lock_timeout_minutes', 30);

        // Bタイプタスクの優先順位（依存関係に基づく順序）
        $taskPriorities = [
            'catchphrase',       // 1. キャッチフレーズ生成（最初）
            'model_plan',        // 2. モデルプラン生成（catchphrase完了後）
            'main_spot',         // 3. メインスポット選定（model_plan完了後）
            'image_selection',   // 4. 画像選定（最後: catchphrase, model_plan, main_spot完了後）
        ];

        foreach ($taskPriorities as $taskType) {
            // このタスク種別で実行中のタスク数を確認
            $runningCount = $this->countRunningTasksForBType($taskType, $lockTimeoutMinutes);

            if ($runningCount >= $maxConcurrent) {
                continue; // このタスク種別はスロットがいっぱい
            }

            // このタスク種別で実行可能なタスクを取得
            $task = $this->findTaskForBType($taskType);

            if ($task) {
                return $task;
            }
        }

        return null;
    }

    /**
     * AタイプとBタイプのどちらを優先するかを決定
     *
     * @return string 'a_type' or 'b_type'
     */
    public function selectTaskType(): string
    {
        $aTypeProbability = config('ai.task_selection.a_type_probability', 0.8);

        return (mt_rand() / mt_getrandmax()) < $aTypeProbability ? 'a_type' : 'b_type';
    }

    /**
     * Bタイプタスクの実行中タスク数をカウント
     */
    private function countRunningTasksForBType(string $taskType, int $lockTimeoutMinutes): int
    {
        // ModelPlanテーブルで管理されるタスク（model_plan, catchphrase, image_selection）
        if ($taskType === 'model_plan' || $taskType === 'catchphrase' || $taskType === 'image_selection') {
            return \App\Models\ModelPlan::whereNotNull("{$taskType}_analyzing_by_model_id")
                ->where("{$taskType}_analyzing_started_at", '>', now()->subMinutes($lockTimeoutMinutes))
                ->count();
        }

        // Clusterテーブルで管理されるタスク（main_spot）
        $analyzingByColumn = "{$taskType}_analyzing_by_model_id";
        $analyzingStartedAtColumn = "{$taskType}_analyzing_started_at";

        return Cluster::whereNotNull($analyzingByColumn)
            ->where($analyzingStartedAtColumn, '>', now()->subMinutes($lockTimeoutMinutes))
            ->count();
    }

    /**
     * Bタイプタスクを検索
     */
    private function findTaskForBType(string $taskType): ?array
    {
        switch ($taskType) {
            case 'image_selection':
                // 画像選定: キャッチフレーズ、モデルプラン、メインスポットが完了しており、画像が未選定のモデルプラン
                $modelPlan = \App\Models\ModelPlan::whereNotNull('catchphrase_analyzed_by_model_id')
                    ->whereNotNull('model_plan_analyzed_by_model_id')
                    ->whereNotNull('main_spot_id')
                    ->whereNull('image_selection_analyzed_by_model_id')
                    ->whereNull('image_selection_analyzing_by_model_id')
                    ->inRandomOrder()
                    ->first();

                return $modelPlan ? ['type' => 'image_selection', 'model_plan' => $modelPlan] : null;

            case 'main_spot':
                // メインスポット選定: キャッチフレーズ生成とモデルプラン生成が完了しているクラスター
                $cluster = Cluster::whereHas('modelPlans', function ($query) {
                    $query->whereNotNull('catchphrase_analyzed_by_model_id')
                        ->whereNotNull('model_plan_analyzed_by_model_id');
                })
                    ->whereNull('main_spot_analyzed_by_model_id')
                    ->whereNull('main_spot_analyzing_by_model_id')
                    ->inRandomOrder()
                    ->first();

                return $cluster ? ['type' => 'main_spot', 'cluster' => $cluster] : null;

            case 'model_plan':
                // モデルプラン生成: キャッチフレーズ生成が完了しているモデルプラン
                $modelPlan = \App\Models\ModelPlan::whereNotNull('catchphrase_analyzed_by_model_id')
                    ->whereNull('model_plan_analyzed_by_model_id')
                    ->whereNull('model_plan_analyzing_by_model_id')
                    ->inRandomOrder()
                    ->first();

                return $modelPlan ? ['type' => 'model_plan', 'model_plan' => $modelPlan] : null;

            case 'catchphrase':
                // キャッチフレーズ生成: 全スポット分析済みのクラスター
                $cluster = Cluster::where('analyzed_spots_count', '>', 0) // 少なくとも1つのスポットが分析済み
                    ->whereColumn('analyzed_spots_count', '=', \DB::raw('(SELECT COUNT(*) FROM cluster_spot WHERE cluster_spot.cluster_id = clusters.id)'))
                    ->where(function ($query) {
                        // モデルプランがないか、キャッチフレーズが未生成
                        $query->whereDoesntHave('modelPlans')
                            ->orWhereHas('modelPlans', function ($q) {
                                $q->whereNull('catchphrase_analyzed_by_model_id')
                                    ->whereNull('catchphrase_analyzing_by_model_id');
                            });
                    })
                    ->inRandomOrder()
                    ->first();

                return $cluster ? ['type' => 'catchphrase', 'cluster' => $cluster] : null;

            default:
                return null;
        }
    }

    /**
     * 使用可能なAIモデルを選定
     *
     * performance_priorityが最も高く、かつ実行間隔制限を満たすモデルを返す
     */
    public function selectAvailableModel(): ?AiModel
    {
        $safetyMargin = config('ai.model_selection.interval_safety_margin', 1.2);
        $historyHours = config('ai.model_selection.execution_history_hours', 24);

        // 有効なモデルを性能順に取得
        $models = AiModel::enabled()
            ->orderByPerformance()
            ->get();

        foreach ($models as $model) {
            // このモデルの最低実行間隔（分）を計算
            $requiredIntervalMinutes = $model->interval_minutes * $safetyMargin;

            // このモデルの最終実行時刻を確認（全タスク種別を横断的に確認）
            $lastExecutedAt = $this->getLastExecutionTime($model, $historyHours);

            if ($lastExecutedAt === null) {
                // このモデルはまだ一度も実行されていない
                return $model;
            }

            // 最終実行からの経過時間を計算（絶対値）
            $minutesSinceLastExecution = $lastExecutedAt->diffInMinutes(now());

            if ($minutesSinceLastExecution >= $requiredIntervalMinutes) {
                // 実行間隔が十分空いている
                return $model;
            }
        }

        return null; // 現在使用可能なモデルがない
    }

    /**
     * 指定されたモデルの最終実行時刻を取得
     *
     * @return \Illuminate\Support\Carbon|null
     */
    private function getLastExecutionTime(AiModel $model, int $historyHours): ?\Illuminate\Support\Carbon
    {
        $sinceTime = now()->subHours($historyHours);

        // Clusterテーブルの全タスク種別から最新の実行時刻を取得
        $clusterColumns = [
            'spot_listing_analyzing_started_at',
            'spot_priority_analyzing_started_at',
            'main_spot_analyzing_started_at',
        ];

        $latestClusterTime = null;
        foreach ($clusterColumns as $column) {
            $analyzingByColumn = str_replace('_started_at', '_by_model_id', $column);
            $analyzedByColumn = str_replace('_analyzing_started_at', '_analyzed_by_model_id', $column);

            // 実行中または完了したタスクの実行時刻を取得
            $time = Cluster::where(function ($query) use ($analyzingByColumn, $analyzedByColumn, $model) {
                $query->where($analyzingByColumn, $model->id)
                    ->orWhere($analyzedByColumn, $model->id);
            })
                ->where($column, '>=', $sinceTime)
                ->max($column);

            // max()は文字列を返すので、Carbonに変換
            if ($time) {
                $time = \Illuminate\Support\Carbon::parse($time);
                if ($latestClusterTime === null || $time->gt($latestClusterTime)) {
                    $latestClusterTime = $time;
                }
            }
        }

        // Spotテーブルの実行時刻を取得（実行中または完了）
        $latestSpotTime = Spot::where(function ($query) use ($model) {
            $query->where('detail_analyzing_by_model_id', $model->id)
                ->orWhere('detail_analyzed_by_model_id', $model->id);
        })
            ->where('detail_analyzing_started_at', '>=', $sinceTime)
            ->max('detail_analyzing_started_at');

        // max()は文字列を返すので、Carbonに変換
        if ($latestSpotTime) {
            $latestSpotTime = \Illuminate\Support\Carbon::parse($latestSpotTime);
        }

        // ModelPlanテーブルの実行時刻を取得
        $modelPlanColumns = [
            'catchphrase_analyzing_started_at',
            'model_plan_analyzing_started_at',
            'image_selection_analyzing_started_at',
        ];

        $latestModelPlanTime = null;
        foreach ($modelPlanColumns as $column) {
            $analyzingByColumn = str_replace('_started_at', '_by_model_id', $column);
            $analyzedByColumn = str_replace('_analyzing_started_at', '_analyzed_by_model_id', $column);

            // 実行中または完了したタスクの実行時刻を取得
            $time = \App\Models\ModelPlan::where(function ($query) use ($analyzingByColumn, $analyzedByColumn, $model) {
                $query->where($analyzingByColumn, $model->id)
                    ->orWhere($analyzedByColumn, $model->id);
            })
                ->where($column, '>=', $sinceTime)
                ->max($column);

            // max()は文字列を返すので、Carbonに変換
            if ($time) {
                $time = \Illuminate\Support\Carbon::parse($time);
                if ($latestModelPlanTime === null || $time->gt($latestModelPlanTime)) {
                    $latestModelPlanTime = $time;
                }
            }
        }

        // 最新の時刻を返す
        $times = array_filter([$latestClusterTime, $latestSpotTime, $latestModelPlanTime]);

        if (empty($times)) {
            return null;
        }

        // 最新のCarbon objectを返す
        return collect($times)->sortDesc()->first();
    }
}
