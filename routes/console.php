<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// AI分析タスクディスパッチャーを定期実行
// 1分ごとに実行し、利用可能なタスクをキューに投入する
Schedule::command('analysis:dispatch')
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground()
    ->onOneServer();

// タイムアウトしたロックを定期的にクリーンアップ
// 1時間ごとに実行
Schedule::command('analysis:cleanup-locks')
    ->hourly()
    ->withoutOverlapping()
    ->onOneServer();
