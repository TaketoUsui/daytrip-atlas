<?php

namespace App\Models;

use App\Enums\SpotRole;
use App\Enums\CoordinateReliability;
use App\Enums\UserSpotInterestStatus;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Spot extends Model
{
    protected $fillable = [
        "name",
        "slug",
        "location",
        "prefecture",
        "municipality",
        "address_detail",
        "min_duration_minutes",
        "max_duration_minutes",
        "spot_role",
        "coordinate_reliability",
    ];

    protected function casts()
    {
        return [
            "min_duration_minutes" => "integer",
            "max_duration_minutes" => "integer",
            "spot_role" => SpotRole::class,
            "coordinate_reliability" => CoordinateReliability::class,
            'location' => Point::class,
        ];
    }

    public function getRouteKeyName(): string{
        return 'slug';
    }

    public function modelPlanItems(): HasMany{
        return $this->hasMany(ModelPlanItem::class);
    }

    public function userInterests(): BelongsToMany{
        return $this->belongsToMany(User::class, "user_spot_interests")
            ->using(UserSpotInterest::class)
            ->withPivot("status", "created_at");
    }

    public function interestedUsers(): BelongsToMany{
        return $this->userInterests()
            ->wherePivot("status", UserSpotInterestStatus::Interested);
    }

    public function clusters(): BelongsToMany{
        return $this->belongsToMany(Cluster::class);
    }

    public function categories(): BelongsToMany{
        return $this->belongsToMany(Category::class, "spot_category");
    }

    public function tags(): BelongsToMany{
        return $this->belongsToMany(Tag::class);
    }

    public function images(): BelongsToMany{
        return $this->belongsToMany(Image::class, "spot_images")
            ->withPivot("display_order")
            ->orderByPivot("display_order");
    }
}
