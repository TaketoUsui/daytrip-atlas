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
    protected $signature = 'analysis:dispatch';

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

        $this->info('Dispatching AI analysis tasks...');

        // タスクディスパッチャージョブをキューに投入
        DispatchAsyncAnalysisTasksJob::dispatch();

        $this->info('Analysis task dispatcher job has been queued');

        return self::SUCCESS;
    }
}
