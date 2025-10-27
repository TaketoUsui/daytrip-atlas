<?php

namespace App\Models;

use App\Enums\ClusterStatus;
use Clickbar\Magellan\Data\Geometries\Point;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property ClusterStatus $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Point|null $location
 * @property-read ModelPlan|null $defaultModelPlan
 * @property-read Collection<int, ModelPlan> $modelPlans
 * @property-read int|null $model_plans_count
 * @property-read Collection<int, Spot> $spots
 * @property-read int|null $spots_count
 * @property-read Collection<int, SuggestionSetItem> $suggestionSetItems
 * @property-read int|null $suggestion_set_items_count
 * @method static Builder<static>|Cluster newModelQuery()
 * @method static Builder<static>|Cluster newQuery()
 * @method static Builder<static>|Cluster query()
 * @method static Builder<static>|Cluster whereCreatedAt($value)
 * @method static Builder<static>|Cluster whereId($value)
 * @method static Builder<static>|Cluster whereLocation($value)
 * @method static Builder<static>|Cluster whereName($value)
 * @method static Builder<static>|Cluster whereStatus($value)
 * @method static Builder<static>|Cluster whereUpdatedAt($value)
 * @method static Builder<static>|Cluster whereUuid($value)
 * @mixin Eloquent
 */
class Cluster extends Model
{
    protected $fillable = [
        "name",
        "location",
        "status",
    ];

    protected function casts(): array
    {
        return [
            "location" => Point::class,
            "status" => ClusterStatus::class,
        ];
    }

    protected static function booted(): void{
        static::creating(function (self $cluster) {
            $cluster->uuid = $cluster->uuid ?? (string) Str::uuid();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function modelPlans(): HasMany{
        return $this->hasMany(ModelPlan::class);
    }
    public function defaultModelPlan(): HasOne{
        return $this->hasOne(ModelPlan::class)->where("is_default", true);
    }

    public function suggestionSetItems(): HasMany{
        return $this->hasMany(SuggestionSetItem::class);
    }

    public function spots(): BelongsToMany{
        return $this->belongsToMany(Spot::class);
    }
}
