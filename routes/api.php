<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\SpotInterestController;
use App\Http\Controllers\Api\V1\SuggestionStatusController;
use App\Http\Controllers\Api\V1\UserActionLogController;

Route::prefix("v1")->group(function () {
    Route::get("/suggestions/{uuid}/status", [SuggestionStatusController::class, "show"])
        ->name("api.v1.suggestion.status");

    Route::post("/spots/{spot}/interest", [SpotInterestController::class, "store"])
        ->name("api.v1.spots.interest");

    Route::post("/logs/action", [UserActionLogController::class, "store"])
        ->name("api.v1.logs.action");
});
