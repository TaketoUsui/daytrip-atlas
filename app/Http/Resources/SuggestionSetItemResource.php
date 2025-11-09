<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\SuggestionSetItem
 */
class SuggestionSetItemResource extends JsonResource
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
            'cluster_uuid' => $this->cluster->uuid,
            'cluster_name' => $this->cluster->name,
            'key_visual_url' => $this->keyVisualImage?->public_url,
            'catchphrase_content' => $this->catchphrase?->content,
            'generated_travel_time_text' => $this->generated_travel_time_text,
            'display_order' => $this->display_order,
        ];
    }
}
