<?php

use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\SuggestionSetItemController;
use App\Http\Controllers\TopController;
use Illuminate\Support\Facades\Route;

/**
 * MVPルート定義
 */

// トップページ（出発地入力）
Route::get('/', [TopController::class, 'index'])->name('top');

// 提案リクエスト作成
Route::post('/suggestions', [TopController::class, 'store'])->name('suggestions.store');

// 提案待機・結果一覧ページ（ポーリング対応）
Route::get('/suggestions/{suggestionSet:uuid}', [SuggestionController::class, 'show'])->name('suggestions.show');

// 提案アイテム詳細ページ（パーソナライズされた観光地提案の詳細）
Route::get('/suggestions/detail/{suggestionSetItem:uuid}', [SuggestionSetItemController::class, 'show'])->name('suggestions.detail');
