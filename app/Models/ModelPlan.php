<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $cluster_id
 * @property string $name
 * @property string|null $description
 * @property int $total_duration_minutes
 * @property bool $is_default
 * @property Carbon|null $created_at
 * @property-read Cluster $cluster
 * @property-read Collection<int, ModelPlanItem> $items
 * @property-read int|null $items_count
 * @property-read Collection<int, SuggestionSetItem> $suggestionSetItems
 * @property-read int|null $suggestion_set_items_count
 * @method static Builder<static>|ModelPlan newModelQuery()
 * @method static Builder<static>|ModelPlan newQuery()
 * @method static Builder<static>|ModelPlan query()
 * @method static Builder<static>|ModelPlan whereClusterId($value)
 * @method static Builder<static>|ModelPlan whereCreatedAt($value)
 * @method static Builder<static>|ModelPlan whereDescription($value)
 * @method static Builder<static>|ModelPlan whereId($value)
 * @method static Builder<static>|ModelPlan whereIsDefault($value)
 * @method static Builder<static>|ModelPlan whereName($value)
 * @method static Builder<static>|ModelPlan whereTotalDurationMinutes($value)
 * @mixin Eloquent
 */
class ModelPlan extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        "cluster_id",
        "name",
        "description",
        "total_duration_minutes",
        "is_default",
    ];

    protected function casts(): array
    {
        return [
            "total_duration_minutes" => "integer",
            "is_default" => "boolean",
        ];
    }

    public function cluster(): BelongsTo{
        return $this->belongsTo(Cluster::class);
    }

    public function suggestionSetItems(): HasMany{
        return $this->hasMany(SuggestionSetItem::class);
    }

    public function items(): HasMany{
        return $this->hasMany(ModelPlanItem::class)->orderBy("display_order");
    }
}
