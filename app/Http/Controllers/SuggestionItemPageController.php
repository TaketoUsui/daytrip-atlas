<?php

namespace App\Http\Controllers;

use App\Models\SuggestionSetItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class SuggestionItemPageController extends Controller
{
    /**
     * No.5 観光地域詳細ページの表示
     *
     * @param Request $request
     * @param SuggestionSetItem $suggestionSetItem (UUIDによるルートモデルバインディング)
     * @return InertiaResponse
     */
    public function show(Request $request, SuggestionSetItem $suggestionSetItem): InertiaResponse
    {
        $suggestionSetItem->load([
            'catchphrase:id,content',
            'cluster:id,name',
            'modelPlan:id,name,description',
            'modelPlan.items',
            'modelPlan.items.spot:id,name,location,address_detail,min_duration_minutes',
        ]);

        return Inertia::render('ClusterDetailPage', [
            'item' => $suggestionSetItem,
        ]);
    }
}
