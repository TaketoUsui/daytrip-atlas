<?php

namespace App\Models;

use App\Enums\ClusterStatus;
use Clickbar\Magellan\Data\Geometries\Point;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 *
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
 *
 * @mixin Eloquent
 */
class Cluster extends Model
{
    protected $fillable = [
        'name',
        'location',
        'status',
        'tourism_value',
        'analyzed_spots_count',
        'spot_listing_analyzed_by_model_id',
        'spot_listing_analyzing_by_model_id',
        'spot_listing_analyzing_started_at',
        'spot_priority_analyzed_by_model_id',
        'spot_priority_analyzing_by_model_id',
        'spot_priority_analyzing_started_at',
        'main_spot_analyzed_by_model_id',
        'main_spot_analyzing_by_model_id',
        'main_spot_analyzing_started_at',
    ];

    protected function casts(): array
    {
        return [
            'location' => Point::class,
            'status' => ClusterStatus::class,
            // AI分析タイムスタンプのキャスト
            'spot_listing_analyzing_started_at' => 'datetime',
            'spot_priority_analyzing_started_at' => 'datetime',
            'main_spot_analyzing_started_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $cluster) {
            $cluster->uuid = $cluster->uuid ?? (string) Str::uuid();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function modelPlans(): HasMany
    {
        return $this->hasMany(ModelPlan::class);
    }

    public function defaultModelPlan(): HasOne
    {
        return $this->hasOne(ModelPlan::class)->where('is_default', true);
    }

    public function spots(): BelongsToMany
    {
        return $this->belongsToMany(Spot::class);
    }

    // AI分析関連のリレーション
    public function spotListingAnalyzedByModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class, 'spot_listing_analyzed_by_model_id');
    }

    public function spotListingAnalyzingByModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class, 'spot_listing_analyzing_by_model_id');
    }

    public function spotPriorityAnalyzedByModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class, 'spot_priority_analyzed_by_model_id');
    }

    public function spotPriorityAnalyzingByModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class, 'spot_priority_analyzing_by_model_id');
    }

    public function mainSpotAnalyzedByModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class, 'main_spot_analyzed_by_model_id');
    }

    public function mainSpotAnalyzingByModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class, 'main_spot_analyzing_by_model_id');
    }
}
