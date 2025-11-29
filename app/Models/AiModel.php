<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * AIモデル管理
 *
 * 利用可能なAIモデルを管理し、性能優先度や利用上限を動的に制御する
 *
 * @property int $id
 * @property string $model_name
 * @property string $provider
 * @property int $performance_priority
 * @property int $daily_limit
 * @property bool $enabled
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class AiModel extends Model
{
    protected $fillable = [
        'model_name',
        'provider',
        'performance_priority',
        'daily_limit',
        'enabled',
    ];

    protected $casts = [
        'performance_priority' => 'integer',
        'daily_limit' => 'integer',
        'enabled' => 'boolean',
    ];

    /**
     * 有効なAIモデルのスコープ
     */
    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    /**
     * 性能優先度順でソートするスコープ（数値が大きいほど高性能）
     */
    public function scopeOrderByPerformance($query)
    {
        return $query->orderBy('performance_priority', 'desc');
    }

    /**
     * 1分あたりの実行間隔を計算（分単位）
     */
    public function getIntervalMinutesAttribute(): float
    {
        return max(1, 1440 / $this->daily_limit);
    }

    /**
     * このモデルがスポットリストアップ分析を完了したクラスター
     */
    public function clustersAnalyzedForSpotListing(): HasMany
    {
        return $this->hasMany(Cluster::class, 'spot_listing_analyzed_by_model_id');
    }

    /**
     * このモデルがスポット詳細分析を完了したスポット
     */
    public function spotsAnalyzedForDetail(): HasMany
    {
        return $this->hasMany(Spot::class, 'detail_analyzed_by_model_id');
    }

    /**
     * このモデルがキャッチフレーズ生成を完了したモデルプラン
     */
    public function modelPlansAnalyzedForCatchphrase(): HasMany
    {
        return $this->hasMany(ModelPlan::class, 'catchphrase_analyzed_by_model_id');
    }

    /**
     * このモデルの実行ログ
     */
    public function executionLogs(): HasMany
    {
        return $this->hasMany(AiModelExecutionLog::class);
    }
}
