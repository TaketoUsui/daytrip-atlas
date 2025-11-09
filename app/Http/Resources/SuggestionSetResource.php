<?php

namespace App\Http\Resources;

use App\Enums\SuggestionStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\SuggestionSet
 */
class SuggestionSetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'status' => $this->status->value,
            'status_message' => $this->status->getMessage(),

            // statusがcompleteの場合のみitemsを含める
            'items' => $this->when(
                $this->status === SuggestionStatus::Complete,
                fn() => SuggestionSetItemResource::collection($this->items)
            ),
        ];
    }
}
