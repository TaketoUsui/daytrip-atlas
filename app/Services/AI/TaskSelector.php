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
                $maxFailureCount = config('ai.task_selection.spot_detail_max_failure_count', 5);

                $spot = Spot::whereNull('detail_analyzed_by_model_id')
                    ->whereNull('detail_analyzing_by_model_id')
                    ->whereNotNull('analysis_priority')
                    ->where('detail_analysis_failure_count', '<', $maxFailureCount)
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
     * 優先順位:
     * 1. 画像選定（最優先）
     * 2. メインスポット選定
     * 3. モデルプラン生成
     * 4. キャッチフレーズ生成
     *
     * 注: 各タスクは前提条件を満たす必要がある（例: image_selectionはmain_spot完了後のみ実行可能）
     *
     * @return array{type: string, cluster?: Cluster, model_plan?: ModelPlan}|null
     */
    public function selectBTypeTask(): ?array
    {
        $maxConcurrent = config('ai.task_selection.max_concurrent_tasks_per_type', 3);
        $lockTimeoutMinutes = config('ai.task_selection.task_lock_timeout_minutes', 30);

        // Bタイプタスクの優先順位（優先度の高い順、前提条件は各findメソッド内で検証）
        $taskPriorities = [
            'image_selection',   // 1. 画像選定（最優先、前提: catchphrase, model_plan, main_spot完了）
            'main_spot',         // 2. メインスポット選定（前提: catchphrase, model_plan完了）
            'model_plan',        // 3. モデルプラン生成（前提: catchphrase完了）
            'catchphrase',       // 4. キャッチフレーズ生成（前提: スポット分析完了）
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
                // analyzed_spots_countは成功・失敗を問わず処理完了したスポット数をカウント
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
     * performance_priorityが最も高く、かつ日次上限に達していないモデルを返す
     *
     * 改善点:
     * - 実行間隔ではなく、実際の実行回数をカウント
     * - ai_model_execution_logsテーブルを使用した正確な上限管理
     */
    public function selectAvailableModel(): ?AiModel
    {
        // 有効なモデルを性能順に取得
        $models = AiModel::enabled()
            ->orderByPerformance()
            ->get();

        foreach ($models as $model) {
            if ($this->canExecuteModel($model)) {
                return $model;
            }
        }

        return null; // 現在使用可能なモデルがない
    }

    /**
     * モデルが実行可能かどうかを判定
     *
     * Gemini APIの日次上限は太平洋時間（PT）の午前0時にリセットされるため、
     * PT基準で「今日」の実行回数をカウントする
     *
     * @param  AiModel  $model
     * @return bool
     */
    private function canExecuteModel(AiModel $model): bool
    {
        // 太平洋時間（PT）基準で「今日」の開始時刻を取得
        $todayStartInPT = $this->getTodayStartInPacificTime();

        // PT基準で「今日」の実行回数をカウント
        $executionCount = \App\Models\AiModelExecutionLog::where('ai_model_id', $model->id)
            ->where('executed_at', '>=', $todayStartInPT)
            ->count();

        // 上限に達していないかチェック
        return $executionCount < $model->daily_limit;
    }

    /**
     * 太平洋時間（PT）基準で「今日」の開始時刻を取得
     *
     * Gemini APIの日次上限は太平洋時間の午前0時にリセットされる
     * - 標準時（PST）: UTC-8, JST 17:00
     * - 夏時間（PDT）: UTC-7, JST 16:00
     *
     * @return \Illuminate\Support\Carbon
     */
    private function getTodayStartInPacificTime(): \Illuminate\Support\Carbon
    {
        $timezone = config('ai.model_selection.api_reset_timezone', 'America/Los_Angeles');

        // 現在時刻を太平洋時間に変換
        $nowInPT = now()->setTimezone($timezone);

        // 太平洋時間で「今日」の午前0時を取得
        $todayStartInPT = $nowInPT->copy()->startOfDay();

        // アプリケーションのタイムゾーン（UTC）に戻す
        return $todayStartInPT->setTimezone(config('app.timezone', 'UTC'));
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
