<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Spot
 */
class SpotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->slug, // Props定義に合わせてuuidとして返す (実際はslugを使用)
            'name' => $this->name,
            'latitude' => $this->location?->getLatitude(),
            'longitude' => $this->location?->getLongitude(),
            'address_detail' => $this->address_detail,
            'prefecture' => $this->prefecture,
            'municipality' => $this->municipality,
        ];
    }
}
