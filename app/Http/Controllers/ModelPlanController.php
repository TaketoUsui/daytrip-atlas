<?php

namespace App\Http\Controllers;

use App\Http\Resources\ModelPlanResource;
use App\Models\SuggestionSetModelPlan;
use Inertia\Inertia;
use Inertia\Response;

class ModelPlanController extends Controller
{
    /**
     * モデルプラン詳細ページ表示
     *
     * @param SuggestionSetModelPlan $suggestionSetModelPlan ピボットレコード（UUID 経由でバインド）
     */
    public function show(SuggestionSetModelPlan $suggestionSetModelPlan): Response
    {
        // リレーションをロード
        $suggestionSetModelPlan->load([
            'modelPlan.cluster',
            'modelPlan.image',
            'modelPlan.catchphrase',
            'modelPlan.items.spot',
            'suggestionSet',
        ]);

        $modelPlan = $suggestionSetModelPlan->modelPlan;
        $suggestionSet = $suggestionSetModelPlan->suggestionSet;

        return Inertia::render('Suggestion/Detail', [
            'modelPlan' => (new ModelPlanResource($modelPlan))->resolve(),
            'suggestionSetUuid' => $suggestionSet->uuid,
            'generatedTravelTimeText' => $suggestionSetModelPlan->generated_travel_time_text,
        ]);
    }
}
