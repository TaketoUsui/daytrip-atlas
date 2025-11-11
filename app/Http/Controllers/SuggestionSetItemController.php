<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClusterResource;
use App\Http\Resources\ModelPlanResource;
use App\Models\SuggestionSetItem;
use Inertia\Inertia;
use Inertia\Response;

class SuggestionSetItemController extends Controller
{
    /**
     * 提案アイテム詳細ページ表示
     *
     * パーソナライズされた観光地提案の詳細を表示
     */
    public function show(SuggestionSetItem $suggestionSetItem): Response
    {
        // 必要なリレーションをロード
        $suggestionSetItem->load([
            'cluster',
            'keyVisualImage',
            'catchphrase',
            'modelPlan.items.spot',
            'suggestionSet',
        ]);

        return Inertia::render('Suggestion/Detail', [
            'suggestionSetItem' => [
                'uuid' => $suggestionSetItem->uuid,
                'suggestion_set_uuid' => $suggestionSetItem->suggestionSet->uuid,
                'cluster_name' => $suggestionSetItem->cluster->name,
                'key_visual_url' => $suggestionSetItem->keyVisualImage?->public_url,
                'catchphrase' => $suggestionSetItem->catchphrase?->content,
                'generated_travel_time_text' => $suggestionSetItem->generated_travel_time_text,
            ],
            'cluster' => (new ClusterResource($suggestionSetItem->cluster))->resolve(),
            'modelPlan' => (new ModelPlanResource($suggestionSetItem->modelPlan))->resolve(),
        ]);
    }
}
