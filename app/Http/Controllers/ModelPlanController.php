<?php

namespace App\Http\Controllers;

use App\Http\Resources\ModelPlanResource;
use App\Models\ModelPlan;
use Inertia\Inertia;
use Inertia\Response;

class ModelPlanController extends Controller
{
    /**
     * モデルプラン詳細ページ表示
     */
    public function show(ModelPlan $modelPlan): Response
    {
        // 必要なリレーションをロード
        $modelPlan->load([
            'cluster',
            'image',
            'catchphrase',
            'items.spot',
        ]);

        // モデルプランが属する提案セットを取得（戻るリンク用）
        $suggestionSet = $modelPlan->suggestionSets()
            ->latest()
            ->first();

        return Inertia::render('Suggestion/Detail', [
            'modelPlan' => (new ModelPlanResource($modelPlan))->resolve(),
            'suggestionSetUuid' => $suggestionSet?->uuid,
        ]);
    }
}
