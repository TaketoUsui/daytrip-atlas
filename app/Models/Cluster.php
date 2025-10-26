<?php

namespace App\Models;

use App\Enums\ClusterStatus;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Cluster extends Model
{
    protected $fillable = [
        "name",
        "location",
        "status",
    ];

    protected function casts()
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

    public function getRouteKeyName()
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
