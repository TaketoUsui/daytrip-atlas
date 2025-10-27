<?php

namespace App\Models;

use App\Enums\SpotRole;
use App\Enums\CoordinateReliability;
use App\Enums\UserSpotInterestStatus;
use Clickbar\Magellan\Data\Geometries\Point;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;


/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $prefecture
 * @property string|null $municipality
 * @property string|null $address_detail
 * @property int $min_duration_minutes
 * @property int $max_duration_minutes
 * @property SpotRole $spot_role
 * @property CoordinateReliability $coordinate_reliability
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Point|null $location
 * @property-read Collection<int, Category> $categories
 * @property-read int|null $categories_count
 * @property-read Collection<int, Cluster> $clusters
 * @property-read int|null $clusters_count
 * @property-read Collection<int, Image> $images
 * @property-read int|null $images_count
 * @property-read UserSpotInterest|null $pivot
 * @property-read Collection<int, User> $interestedUsers
 * @property-read int|null $interested_users_count
 * @property-read Collection<int, ModelPlanItem> $modelPlanItems
 * @property-read int|null $model_plan_items_count
 * @property-read Collection<int, Tag> $tags
 * @property-read int|null $tags_count
 * @property-read Collection<int, User> $userInterests
 * @property-read int|null $user_interests_count
 * @method static Builder<static>|Spot newModelQuery()
 * @method static Builder<static>|Spot newQuery()
 * @method static Builder<static>|Spot query()
 * @method static Builder<static>|Spot whereAddressDetail($value)
 * @method static Builder<static>|Spot whereCoordinateReliability($value)
 * @method static Builder<static>|Spot whereCreatedAt($value)
 * @method static Builder<static>|Spot whereId($value)
 * @method static Builder<static>|Spot whereLocation($value)
 * @method static Builder<static>|Spot whereMaxDurationMinutes($value)
 * @method static Builder<static>|Spot whereMinDurationMinutes($value)
 * @method static Builder<static>|Spot whereMunicipality($value)
 * @method static Builder<static>|Spot whereName($value)
 * @method static Builder<static>|Spot wherePrefecture($value)
 * @method static Builder<static>|Spot whereSlug($value)
 * @method static Builder<static>|Spot whereSpotRole($value)
 * @method static Builder<static>|Spot whereUpdatedAt($value)
 * @mixin Eloquent
 */
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

    protected function casts(): array
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
