<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopPageController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\SuggestionController;

Route::get("/", [TopPageController::class, "show"])
    ->name("top");

Route::post("/suggestions", [SuggestionController::class, "store"])
    ->name("suggestions.store");

Route::get("/suggestions/{uuid}/wait", [SuggestionController::class, "wait"])
    ->name("suggestions.wait");

Route::get("/suggestions/{uuid}", [SuggestionController::class, "show"])
    ->name("suggestions.show");

Route::get("/clusters/{suggestion_set_item_uuid}", [ClusterController::class, "show"])
    ->name("clusters.show");
