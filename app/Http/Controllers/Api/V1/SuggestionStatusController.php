<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuggestionStatusResource;
use App\Models\SuggestionSet;
use Illuminate\Http\Request;

class SuggestionStatusController extends Controller
{
    /**
     * No.6 提案ステータス取得
     *
     * @param Request $request
     * @param SuggestionSet $suggestionSet
     * @return SuggestionStatusResource
     */
    public function getStatus(Request $request, SuggestionSet $suggestionSet){
        $suggestionSet->loadMissing([
            "items.cluster:id,name",
        ]);

        return new SuggestionStatusResource($suggestionSet);
    }
}
