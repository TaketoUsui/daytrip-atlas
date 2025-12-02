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

        // モデルプランが属する提案セットを取得（戻るリンク用と片道移動時間取得用）
        $suggestionSet = $modelPlan->suggestionSets()
            ->latest()
            ->first();

        // ピボットテーブル (suggestion_set_model_plans) から片道移動時間を取得
        $generatedTravelTimeText = null;
        if ($suggestionSet) {
            $pivot = $modelPlan->suggestionSets()
                ->where('suggestion_sets.id', $suggestionSet->id)
                ->first()
                ?->pivot;
            $generatedTravelTimeText = $pivot?->generated_travel_time_text;
        }

        return Inertia::render('Suggestion/Detail', [
            'modelPlan' => (new ModelPlanResource($modelPlan))->resolve(),
            'suggestionSetUuid' => $suggestionSet?->uuid,
            'generatedTravelTimeText' => $generatedTravelTimeText,
        ]);
    }
}
