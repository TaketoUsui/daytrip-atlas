<?php

namespace App\Http\Resources;

use App\Enums\SuggestionStatus;
use App\Models\SuggestionSet;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SuggestionSet
 */
class SuggestionStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "status" => $this->status->value,
            "message" => $this->status->getMessage(),
            "found_clusters" => $this->when(
                $this->status !== SuggestionStatus::Pending,
                function () {
                    return $this->items->map(fn($item) => [
                        "id" => $item->cluster->id,
                        "name" => $item->cluster->name,
                    ]);
                },
                []
            ),
        ];
    }
}
