<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\ModelPlan
 */
class ModelPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'total_duration_minutes' => $this->total_duration_minutes,
            'items' => ModelPlanItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
