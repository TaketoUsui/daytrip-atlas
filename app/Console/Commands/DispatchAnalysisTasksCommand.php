<?php

namespace App\Console\Commands;

use App\Jobs\DispatchAsyncAnalysisTasksJob;
use Illuminate\Console\Command;

/**
 * 非同期AI分析タスクをディスパッチするコマンド
 *
 * 使用方法:
 * php artisan analysis:dispatch
 *
 * スケジューラーに登録することで定期実行可能:
 * $schedule->command('analysis:dispatch')->everyMinute();
 */
class DispatchAnalysisTasksCommand extends Command
{
    /**
     * コマンド名と引数
     */
    protected $signature = 'analysis:dispatch {--count=1 : Number of jobs to dispatch in parallel}';

    /**
     * コマンドの説明
     */
    protected $description = 'Dispatch AI analysis tasks (A-type and B-type)';

    /**
     * コマンドの実行
     */
    public function handle(): int
    {
        if (! config('ai.async_analysis_enabled', true)) {
            $this->warn('AI async analysis is disabled in config');

            return self::FAILURE;
        }

        $count = (int) $this->option('count');

        if ($count < 1) {
            $this->error('Count must be at least 1');

            return self::FAILURE;
        }

        $this->info("Dispatching {$count} AI analysis task(s)...");

        // 指定された回数だけタスクディスパッチャージョブをキューに投入
        for ($i = 0; $i < $count; $i++) {
            DispatchAsyncAnalysisTasksJob::dispatch();
        }

        $this->info("{$count} analysis task dispatcher job(s) have been queued");

        return self::SUCCESS;
    }
}
