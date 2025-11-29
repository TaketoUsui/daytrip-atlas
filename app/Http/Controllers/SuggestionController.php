<?php

namespace App\Http\Controllers;

use App\Http\Resources\SuggestionSetResource;
use App\Models\SuggestionSet;
use Inertia\Inertia;
use Inertia\Response;

class SuggestionController extends Controller
{
    /**
     * 提案待機・結果一覧ページ表示
     *
     * ポーリングに対応するため、Inertia.js partial reloadをサポート
     */
    public function show(SuggestionSet $suggestionSet): Response
    {
        // modelPlansリレーションをロード（status=completeの場合に必要）
        $suggestionSet->load([
            'modelPlans.cluster',
            'modelPlans.image',
            'modelPlans.catchphrase',
            'modelPlans.items.spot',
        ]);

        return Inertia::render('Suggestion/Show', [
            'suggestionSet' => (new SuggestionSetResource($suggestionSet))->resolve(),
        ]);
    }
}
