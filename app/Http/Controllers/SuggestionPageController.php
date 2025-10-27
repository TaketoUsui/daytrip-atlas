<?php

namespace App\Http\Controllers;

use App\Enums\SuggestionStatus;
use App\Models\SuggestionSet;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class SuggestionPageController extends Controller
{
    /**
     * No.3 提案待機ページ
     *
     * @param Request $request
     * @param SuggestionSet $suggestionSet
     * @return InertiaResponse
     */
    public function wait(Request $request, SuggestionSet $suggestionSet): InertiaResponse{
        return Inertia::render("SuggestionWaitPage", [
            "uuid" => $suggestionSet->uuid,
        ]);
    }

    public function show(Request $request, SuggestionSet $suggestionSet): InertiaResponse{
        if($suggestionSet->status !== SuggestionStatus::Complete) {
            abort(404, "Suggestion analyze is not yet complete or has failed");
        }

        $suggestionSet->load([
            "items" => fn ($query) => $query->orderBy("display_order"),
            "items.cluster:id,name",
            "items.keyVisualImage:id,storage_path,alt_text",
            "items.catchphrase:id,content",
        ]);

        return Inertia::render("SuggestionResultPage", [
            "suggestionSet" => $suggestionSet,
        ]);
    }
}
