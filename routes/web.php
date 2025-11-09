<?php

use App\Http\Controllers\TopController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\ClusterController;
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

// クラスター詳細ページ
Route::get('/clusters/{cluster:uuid}', [ClusterController::class, 'show'])->name('clusters.show');
