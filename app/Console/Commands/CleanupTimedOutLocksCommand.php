<?php

namespace App\Console\Commands;

use App\Models\Cluster;
use App\Models\ModelPlan;
use App\Models\Spot;
use App\Services\AI\LockManager;
use Illuminate\Console\Command;

/**
 * タイムアウトした分析ロックをクリーンアップするコマンド
 *
 * 使用方法:
 * php artisan analysis:cleanup-locks
 *
 * スケジューラーに登録することで定期実行可能:
 * $schedule->command('analysis:cleanup-locks')->hourly();
 */
class CleanupTimedOutLocksCommand extends Command
{
    /**
     * コマンド名と引数
     */
    protected $signature = 'analysis:cleanup-locks';

    /**
     * コマンドの説明
     */
    protected $description = 'Cleanup timed-out analysis locks';

    /**
     * コマンドの実行
     */
    public function handle(LockManager $lockManager): int
    {
        $this->info('Cleaning up timed-out analysis locks...');

        $totalReleased = 0;

        // Spotの詳細分析ロックをクリーンアップ
        $spotLocksReleased = $lockManager->releaseTimedOutLocks(Spot::class, 'detail');
        $totalReleased += $spotLocksReleased;

        if ($spotLocksReleased > 0) {
            $this->line("Released {$spotLocksReleased} timed-out spot detail analysis locks");
        }

        // Clusterのタスクロックをクリーンアップ
        $clusterTaskTypes = ['spot_listing', 'spot_priority', 'main_spot'];

        foreach ($clusterTaskTypes as $taskType) {
            $released = $lockManager->releaseTimedOutLocks(Cluster::class, $taskType);
            $totalReleased += $released;

            if ($released > 0) {
                $this->line("Released {$released} timed-out cluster {$taskType} locks");
            }
        }

        // ModelPlanのタスクロックをクリーンアップ
        $modelPlanTaskTypes = ['image_selection', 'model_plan', 'catchphrase'];

        foreach ($modelPlanTaskTypes as $taskType) {
            $released = $lockManager->releaseTimedOutLocks(ModelPlan::class, $taskType);
            $totalReleased += $released;

            if ($released > 0) {
                $this->line("Released {$released} timed-out model_plan {$taskType} locks");
            }
        }

        if ($totalReleased === 0) {
            $this->info('No timed-out locks found');
        } else {
            $this->info("Total locks released: {$totalReleased}");
        }

        return self::SUCCESS;
    }
}
