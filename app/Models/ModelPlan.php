<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
 *
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
 *
 * @mixin Eloquent
 */
class ModelPlan extends Model
{
    protected $fillable = [
        'cluster_id',
        'main_spot_id',
        'image_id',
        'name',
        'description',
        'total_duration_minutes',
        'is_default',
        'catchphrase_analyzed_by_model_id',
        'catchphrase_analyzing_by_model_id',
        'catchphrase_analyzing_started_at',
        'model_plan_analyzed_by_model_id',
        'model_plan_analyzing_by_model_id',
        'model_plan_analyzing_started_at',
        'image_selection_analyzed_by_model_id',
        'image_selection_analyzing_by_model_id',
        'image_selection_analyzing_started_at',
    ];

    protected function casts(): array
    {
        return [
            'total_duration_minutes' => 'integer',
            'is_default' => 'boolean',
            // AI分析タイムスタンプのキャスト
            'catchphrase_analyzing_started_at' => 'datetime',
            'model_plan_analyzing_started_at' => 'datetime',
            'image_selection_analyzing_started_at' => 'datetime',
        ];
    }

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class);
    }

    public function mainSpot(): BelongsTo
    {
        return $this->belongsTo(Spot::class, 'main_spot_id');
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function catchphrase(): HasOne
    {
        return $this->hasOne(Catchphrase::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ModelPlanItem::class)->orderBy('display_order');
    }

    public function suggestionSets(): BelongsToMany
    {
        return $this->belongsToMany(SuggestionSet::class, 'suggestion_set_model_plans')
            ->using(SuggestionSetModelPlan::class)
            ->withPivot('uuid', 'display_order', 'generated_travel_time_text', 'created_at');
    }

    // AI分析関連のリレーション
    public function catchphraseAnalyzedByModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class, 'catchphrase_analyzed_by_model_id');
    }

    public function catchphraseAnalyzingByModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class, 'catchphrase_analyzing_by_model_id');
    }

    public function modelPlanAnalyzedByModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class, 'model_plan_analyzed_by_model_id');
    }

    public function modelPlanAnalyzingByModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class, 'model_plan_analyzing_by_model_id');
    }

    public function imageSelectionAnalyzedByModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class, 'image_selection_analyzed_by_model_id');
    }

    public function imageSelectionAnalyzingByModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class, 'image_selection_analyzing_by_model_id');
    }
}
