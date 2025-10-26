<?php

namespace App\Models;

use App\Enums\TravelMode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModelPlanItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        "model_plan_id",
        "display_order",
        "spot_id",
        "duration_minutes",
        "travel_time_to_next_minutes",
        "travel_mode",
        "description",
    ];

    protected function casts()
    {
        return [
            "display_order" => "integer",
            "duration_minutes" => "integer",
            "travel_time_to_next_minutes" => "integer",
            "travel_mode" => TravelMode::class,
        ];
    }

    public function modelPlan(): BelongsTo{
        return $this->belongsTo(ModelPlan::class);
    }

    public function spot(): BelongsTo{
        return $this->belongsTo(Spot::class);
    }
}
