<?php

namespace App\Services;

use App\Enums\SuggestionStatus;
use App\Jobs\GenerateSuggestionsJob;
use App\Models\SuggestionSet;
use Illuminate\Support\Facades\Auth;

class SuggestionService
{
    public function createAndDispatch(array $validatedData, string $sessionId): SuggestionSet{
        $suggestionSet = SuggestionSet::create([
            "session_id" => $sessionId,
            "user_id" => Auth::id(),
            "status" => SuggestionStatus::Pending,
            "input_latitude" => $validatedData["latitude"],
            "input_longitude" => $validatedData["longitude"],
            "input_tags_json" => $validatedData["tags"] ?? [],
        ]);

        GenerateSuggestionsJob::dispatch($suggestionSet);

        return $suggestionSet;
    }
}
