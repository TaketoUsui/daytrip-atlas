<?php

use App\Http\Controllers\Admin\AdminTopPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopPageController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\SuggestionPageController;
use App\Http\Controllers\SuggestionItemPageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClusterController;
use App\Http\Controllers\Admin\SpotController;
use App\Http\Controllers\Admin\TagController;

// No.1 トップページ
Route::get('/', [TopPageController::class, 'show'])
    ->name('top');

// No.2 提案リクエスト受付
Route::post('/suggestions', [SuggestionController::class, 'store'])
    ->name('suggestions.store');

// No.3 提案待機ページ
Route::get('/suggestions/{suggestion_set:uuid}/wait', [SuggestionPageController::class, 'wait'])
    ->name('suggestions.wait');

// No.4 提案結果一覧
Route::get('/suggestions/{suggestion_set:uuid}', [SuggestionPageController::class, 'show'])
    ->name('suggestions.show');

// No.5 観光地域詳細
Route::get('/suggested-cluster/{suggestion_set_item:uuid}', [SuggestionItemPageController::class, 'show'])
    ->name('suggestions.item.show');

Route::middleware(['auth'])
->prefix('admin')
->name('admin.')
->group(function () {
    Route::get("/", [AdminTopPageController::class, "show"])
        ->name('top');

    // スポット管理 (CRUD)
    Route::resource('spots', SpotController::class);

    // クラスター管理 (CRUD)
    Route::resource('clusters', ClusterController::class);

    // タグ管理 (CRUD)
    Route::resource('model-plans', TagController::class);

    // カテゴリ管理 (CRUD)
    Route::resource('model-plans', CategoryController::class);
});
