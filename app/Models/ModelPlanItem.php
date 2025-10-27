<?php

namespace App\Models;

use App\Enums\TravelMode;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $model_plan_id
 * @property int $display_order
 * @property int $spot_id
 * @property int $duration_minutes
 * @property int $travel_time_to_next_minutes
 * @property TravelMode|null $travel_mode
 * @property string|null $description
 * @property-read ModelPlan $modelPlan
 * @property-read Spot $spot
 * @method static Builder<static>|ModelPlanItem newModelQuery()
 * @method static Builder<static>|ModelPlanItem newQuery()
 * @method static Builder<static>|ModelPlanItem query()
 * @method static Builder<static>|ModelPlanItem whereDescription($value)
 * @method static Builder<static>|ModelPlanItem whereDisplayOrder($value)
 * @method static Builder<static>|ModelPlanItem whereDurationMinutes($value)
 * @method static Builder<static>|ModelPlanItem whereId($value)
 * @method static Builder<static>|ModelPlanItem whereModelPlanId($value)
 * @method static Builder<static>|ModelPlanItem whereSpotId($value)
 * @method static Builder<static>|ModelPlanItem whereTravelMode($value)
 * @method static Builder<static>|ModelPlanItem whereTravelTimeToNextMinutes($value)
 * @mixin Eloquent
 */
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

    protected function casts(): array
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
