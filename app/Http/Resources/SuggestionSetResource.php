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
            'processing_details' => $this->processing_details,

            // statusがcompleteの場合のみitemsを含める（modelPlansをitemsとして返す）
            'items' => $this->when(
                $this->status === SuggestionStatus::Complete,
                fn () => $this->modelPlans->map(function ($modelPlan) {
                    return [
                        'uuid' => $modelPlan->id, // ModelPlanのIDをUUIDとして使用
                        'cluster_uuid' => $modelPlan->cluster->uuid,
                        'cluster_name' => $modelPlan->cluster->name,
                        'key_visual_url' => $modelPlan->image?->public_url,
                        'catchphrase_content' => $modelPlan->catchphrase?->content,
                        'generated_travel_time_text' => $modelPlan->pivot->generated_travel_time_text,
                        'display_order' => $modelPlan->pivot->display_order,
                    ];
                })
            ),
        ];
    }
}
