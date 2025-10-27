<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserSpotInterestController;
use App\Http\Controllers\Api\V1\SuggestionStatusController;
use App\Http\Controllers\Api\V1\UserActionLogController;

Route::prefix('v1')->group(function () {

    // No.6 提案ステータス取得
    Route::get('/suggestions/{suggestion_set:uuid}/status', [SuggestionStatusController::class, 'show'])
        ->name('api.v1.suggestions.status');

    // No.7 明示的フィードバック送信
    Route::post('/spots/{spot:id}/interest', [UserSpotInterestController::class, 'store'])
        ->name('api.v1.spots.interest');

    // No.8 ユーザー行動ログ記録
    Route::post('/logs/action', [UserActionLogController::class, 'store'])
        ->name('api.v1.logs.action');
});
