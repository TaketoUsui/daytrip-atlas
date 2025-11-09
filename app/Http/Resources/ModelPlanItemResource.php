<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\ModelPlanItem
 */
class ModelPlanItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'display_order' => $this->display_order,
            'spot_name' => $this->spot->name,
            'spot_slug' => $this->spot->slug,
            'duration_minutes' => $this->duration_minutes,
            'travel_time_to_next_minutes' => $this->travel_time_to_next_minutes,
            'travel_mode' => $this->travel_mode?->value,
            'description' => $this->description,
        ];
    }
}
