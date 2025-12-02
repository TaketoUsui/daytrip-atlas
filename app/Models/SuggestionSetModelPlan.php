<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * suggestion_set_model_plans ピボットテーブルモデル
 *
 * @property string $uuid
 * @property int $suggestion_set_id
 * @property int $model_plan_id
 * @property int $display_order
 * @property string|null $generated_travel_time_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read SuggestionSet $suggestionSet
 * @property-read ModelPlan $modelPlan
 */
class SuggestionSetModelPlan extends Pivot
{
    use HasUuids;

    protected $table = 'suggestion_set_model_plans';

    // UUID をルートバインディングの主キーとして使用
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    // タイムスタンプは created_at のみ
    const UPDATED_AT = null;

    protected $fillable = [
        'suggestion_set_id',
        'model_plan_id',
        'display_order',
        'generated_travel_time_text',
    ];

    protected function casts(): array
    {
        return [
            'display_order' => 'integer',
        ];
    }

    /**
     * UUID を生成するカラムを指定
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function suggestionSet(): BelongsTo
    {
        return $this->belongsTo(SuggestionSet::class);
    }

    public function modelPlan(): BelongsTo
    {
        return $this->belongsTo(ModelPlan::class);
    }
}
