<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid
 * @property int $suggestion_set_id
 * @property int $cluster_id
 * @property int $key_visual_image_id
 * @property int $catchphrase_id
 * @property int $model_plan_id
 * @property int $display_order
 * @property string|null $generated_travel_time_text
 * @property-read Catchphrase $catchphrase
 * @property-read Cluster $cluster
 * @property-read Image $keyVisualImage
 * @property-read ModelPlan $modelPlan
 * @property-read SuggestionSet $suggestionSet
 * @method static Builder<static>|SuggestionSetItem newModelQuery()
 * @method static Builder<static>|SuggestionSetItem newQuery()
 * @method static Builder<static>|SuggestionSetItem query()
 * @method static Builder<static>|SuggestionSetItem whereCatchphraseId($value)
 * @method static Builder<static>|SuggestionSetItem whereClusterId($value)
 * @method static Builder<static>|SuggestionSetItem whereDisplayOrder($value)
 * @method static Builder<static>|SuggestionSetItem whereGeneratedTravelTimeText($value)
 * @method static Builder<static>|SuggestionSetItem whereId($value)
 * @method static Builder<static>|SuggestionSetItem whereKeyVisualImageId($value)
 * @method static Builder<static>|SuggestionSetItem whereModelPlanId($value)
 * @method static Builder<static>|SuggestionSetItem whereSuggestionSetId($value)
 * @method static Builder<static>|SuggestionSetItem whereUuid($value)
 * @mixin Eloquent
 */
class SuggestionSetItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        "suggestion_set_id",
        "cluster_id",
        "key_visual_image_id",
        "catchphrase_id",
        "model_plan_id",
        "display_order",
        "generated_travel_time_text",
    ];

    protected $casts = [
        "display_order" => "integer",
    ];

    protected static function booted(): void
    {
        static::creating(function (self $item) {
            $item->uuid = $item->uuid ?? (string) Str::uuid();
        });
    }

    public function getRouteKeyName(): string{
        return "uuid";
    }

    public function suggestionSet(): BelongsTo{
        return $this->belongsTo(SuggestionSet::class);
    }

    public function cluster(): BelongsTo{
        return $this->belongsTo(Cluster::class);
    }

    public function keyVisualImage(): BelongsTo{
        return $this->belongsTo(Image::class, 'key_visual_image_id');
    }

    public function catchphrase(): BelongsTo{
        return $this->belongsTo(Catchphrase::class);
    }

    public function modelPlan(): BelongsTo{
        return $this->belongsTo(ModelPlan::class);
    }
}
