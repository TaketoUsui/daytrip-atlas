<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * AIモデル実行ログ
 *
 * AIモデルの実際の実行履歴を記録し、日次上限管理を正確に行う
 *
 * @property int $id
 * @property int $ai_model_id
 * @property \Illuminate\Support\Carbon $executed_at
 * @property string $task_type
 * @property string $status
 * @property string $target_type
 * @property int $target_id
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read AiModel $aiModel
 * @property-read Model $target
 */
class AiModelExecutionLog extends Model
{
    protected $fillable = [
        'ai_model_id',
        'executed_at',
        'task_type',
        'status',
        'target_type',
        'target_id',
        'metadata',
    ];

    protected $casts = [
        'executed_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * このログが属するAIモデル
     */
    public function aiModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class);
    }

    /**
     * ログ対象のエンティティ（Spot, Cluster, ModelPlan）
     */
    public function target(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * 成功したログのスコープ
     */
    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    /**
     * 失敗したログのスコープ
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * 特定期間内のログを取得するスコープ
     */
    public function scopeWithinPeriod($query, \Carbon\Carbon $start, ?\Carbon\Carbon $end = null)
    {
        $query->where('executed_at', '>=', $start);

        if ($end) {
            $query->where('executed_at', '<=', $end);
        }

        return $query;
    }

    /**
     * 特定のタスクタイプのログを取得するスコープ
     */
    public function scopeTaskType($query, string $taskType)
    {
        return $query->where('task_type', $taskType);
    }
}
