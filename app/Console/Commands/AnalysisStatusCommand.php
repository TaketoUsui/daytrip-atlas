<?php

namespace App\Console\Commands;

use App\Models\AiModel;
use App\Models\Cluster;
use App\Models\Spot;
use Illuminate\Console\Command;

/**
 * AI分析の進捗状況を表示するコマンド
 *
 * 使用方法:
 * php artisan analysis:status
 */
class AnalysisStatusCommand extends Command
{
    /**
     * コマンド名と引数
     */
    protected $signature = 'analysis:status
                            {--detailed : Show detailed information}';

    /**
     * コマンドの説明
     */
    protected $description = 'Show AI analysis progress status';

    /**
     * コマンドの実行
     */
    public function handle(): int
    {
        $this->info('=== AI Analysis Status ===');
        $this->newLine();

        // AI Models
        $this->showAiModels();
        $this->newLine();

        // A-type tasks (Spot detail analysis)
        $this->showATypeTasks();
        $this->newLine();

        // B-type tasks (Cluster analysis)
        $this->showBTypeTasks();
        $this->newLine();

        if ($this->option('detailed')) {
            $this->showDetailedStatus();
        }

        return self::SUCCESS;
    }

    /**
     * AIモデルの状態を表示
     */
    private function showAiModels(): void
    {
        $this->line('<fg=cyan>AI Models:</>');

        $models = AiModel::orderBy('performance_priority')->get();

        if ($models->isEmpty()) {
            $this->warn('  No AI models configured');

            return;
        }

        $rows = [];
        foreach ($models as $model) {
            $rows[] = [
                $model->model_name,
                $model->provider,
                $model->performance_priority,
                $model->daily_limit,
                $model->enabled ? '✓' : '✗',
                round($model->interval_minutes, 2).' min',
            ];
        }

        $this->table(
            ['Model', 'Provider', 'Priority', 'Daily Limit', 'Enabled', 'Interval'],
            $rows
        );
    }

    /**
     * Aタイプタスク（スポット詳細分析）の状態を表示
     */
    private function showATypeTasks(): void
    {
        $this->line('<fg=cyan>A-type Tasks (Spot Detail Analysis):</>');

        $totalSpots = Spot::whereNotNull('analysis_priority')->count();
        $analyzedSpots = Spot::whereNotNull('detail_analyzed_by_model_id')->count();
        $analyzingSpots = Spot::whereNotNull('detail_analyzing_by_model_id')->count();
        $pendingSpots = $totalSpots - $analyzedSpots - $analyzingSpots;

        $this->line("  Total spots with priority: <fg=yellow>{$totalSpots}</>");
        $this->line("  Analyzed: <fg=green>{$analyzedSpots}</> (".round($analyzedSpots / max(1, $totalSpots) * 100, 1).'%)');
        $this->line("  Analyzing (in progress): <fg=blue>{$analyzingSpots}</>");
        $this->line("  Pending: <fg=red>{$pendingSpots}</>");
    }

    /**
     * Bタイプタスク（クラスター分析）の状態を表示
     */
    private function showBTypeTasks(): void
    {
        $this->line('<fg=cyan>B-type Tasks (Cluster & Model Plan Analysis):</>');

        $totalClusters = Cluster::count();

        // Clusterベースのタスク
        $clusterTaskTypes = [
            'spot_listing' => 'Spot Listing',
            'spot_priority' => 'Spot Priority',
            'main_spot' => 'Main Spot Selection',
        ];

        foreach ($clusterTaskTypes as $taskType => $label) {
            $analyzedColumn = "{$taskType}_analyzed_by_model_id";
            $analyzingColumn = "{$taskType}_analyzing_by_model_id";

            $analyzed = Cluster::whereNotNull($analyzedColumn)->count();
            $analyzing = Cluster::whereNotNull($analyzingColumn)->count();
            $pending = $totalClusters - $analyzed - $analyzing;

            $this->line("  <fg=white>{$label}:</>");
            $this->line("    Analyzed: <fg=green>{$analyzed}</> | Analyzing: <fg=blue>{$analyzing}</> | Pending: <fg=red>{$pending}</>");
        }

        // ModelPlanベースのタスク
        $totalModelPlans = \App\Models\ModelPlan::count();

        $modelPlanTaskTypes = [
            'image_selection' => 'Image Selection',
            'catchphrase' => 'Catchphrase Generation',
            'model_plan' => 'Model Plan Generation',
        ];

        foreach ($modelPlanTaskTypes as $taskType => $label) {
            $analyzedColumn = "{$taskType}_analyzed_by_model_id";
            $analyzingColumn = "{$taskType}_analyzing_by_model_id";

            $analyzed = \App\Models\ModelPlan::whereNotNull($analyzedColumn)->count();
            $analyzing = \App\Models\ModelPlan::whereNotNull($analyzingColumn)->count();
            $pending = $totalModelPlans - $analyzed - $analyzing;

            $this->line("  <fg=white>{$label}:</>");
            $this->line("    Analyzed: <fg=green>{$analyzed}</> | Analyzing: <fg=blue>{$analyzing}</> | Pending: <fg=red>{$pending}</>");
        }
    }

    /**
     * 詳細な状態を表示
     */
    private function showDetailedStatus(): void
    {
        $this->newLine();
        $this->line('<fg=cyan>Detailed Status:</>');

        // 実行中のタスクを表示
        $lockTimeoutMinutes = config('ai.task_selection.task_lock_timeout_minutes', 30);

        $runningSpots = Spot::whereNotNull('detail_analyzing_by_model_id')
            ->where('detail_analyzing_started_at', '>', now()->subMinutes($lockTimeoutMinutes))
            ->get();

        if ($runningSpots->isNotEmpty()) {
            $this->line('  <fg=yellow>Running Spot Analysis Tasks:</>');
            foreach ($runningSpots as $spot) {
                $elapsed = now()->diffInMinutes($spot->detail_analyzing_started_at);
                $this->line("    - {$spot->name} (started {$elapsed} min ago)");
            }
        }

        $runningClusters = Cluster::where(function ($query) use ($lockTimeoutMinutes) {
            $query->whereNotNull('spot_listing_analyzing_by_model_id')
                ->where('spot_listing_analyzing_started_at', '>', now()->subMinutes($lockTimeoutMinutes));
        })->orWhere(function ($query) use ($lockTimeoutMinutes) {
            $query->whereNotNull('spot_priority_analyzing_by_model_id')
                ->where('spot_priority_analyzing_started_at', '>', now()->subMinutes($lockTimeoutMinutes));
        })->orWhere(function ($query) use ($lockTimeoutMinutes) {
            $query->whereNotNull('main_spot_analyzing_by_model_id')
                ->where('main_spot_analyzing_started_at', '>', now()->subMinutes($lockTimeoutMinutes));
        })->get();

        if ($runningClusters->isNotEmpty()) {
            $this->line('  <fg=yellow>Running Cluster Analysis Tasks:</>');
            foreach ($runningClusters as $cluster) {
                $taskType = null;
                if ($cluster->spot_listing_analyzing_by_model_id) {
                    $taskType = 'spot_listing';
                } elseif ($cluster->spot_priority_analyzing_by_model_id) {
                    $taskType = 'spot_priority';
                } elseif ($cluster->main_spot_analyzing_by_model_id) {
                    $taskType = 'main_spot';
                }
                $this->line("    - {$cluster->name} (task: {$taskType})");
            }
        }

        $runningModelPlans = \App\Models\ModelPlan::where(function ($query) use ($lockTimeoutMinutes) {
            $query->whereNotNull('image_selection_analyzing_by_model_id')
                ->where('image_selection_analyzing_started_at', '>', now()->subMinutes($lockTimeoutMinutes));
        })->orWhere(function ($query) use ($lockTimeoutMinutes) {
            $query->whereNotNull('catchphrase_analyzing_by_model_id')
                ->where('catchphrase_analyzing_started_at', '>', now()->subMinutes($lockTimeoutMinutes));
        })->orWhere(function ($query) use ($lockTimeoutMinutes) {
            $query->whereNotNull('model_plan_analyzing_by_model_id')
                ->where('model_plan_analyzing_started_at', '>', now()->subMinutes($lockTimeoutMinutes));
        })->get();

        if ($runningModelPlans->isNotEmpty()) {
            $this->line('  <fg=yellow>Running Model Plan Analysis Tasks:</>');
            foreach ($runningModelPlans as $modelPlan) {
                $taskType = null;
                if ($modelPlan->image_selection_analyzing_by_model_id) {
                    $taskType = 'image_selection';
                } elseif ($modelPlan->catchphrase_analyzing_by_model_id) {
                    $taskType = 'catchphrase';
                } elseif ($modelPlan->model_plan_analyzing_by_model_id) {
                    $taskType = 'model_plan';
                }
                $this->line("    - {$modelPlan->name} (task: {$taskType})");
            }
        }
    }
}
