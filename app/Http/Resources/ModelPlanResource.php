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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'total_duration_minutes' => $this->total_duration_minutes,
            'items' => ModelPlanItemResource::collection($this->whenLoaded('items'))->resolve(),

            // 詳細ページ用の追加情報
            'cluster_name' => $this->whenLoaded('cluster', fn() => $this->cluster->name),
            'cluster_uuid' => $this->whenLoaded('cluster', fn() => $this->cluster->uuid),
            'key_visual_url' => $this->whenLoaded('image', fn() => $this->image?->public_url),
            'catchphrase' => $this->whenLoaded('catchphrase', fn() => $this->catchphrase?->content),
        ];
    }
}
