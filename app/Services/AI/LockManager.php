<?php

namespace App\Services\AI;

use App\Exceptions\ConcurrentAnalysisException;
use App\Models\AiModel;
use App\Models\Cluster;
use App\Models\Spot;
use Illuminate\Database\Eloquent\Model;

/**
 * AI分析タスクの楽観的ロック管理サービス
 *
 * 複数のワーカーが同じタスクを同時に実行しないよう制御する
 */
class LockManager
{
    /**
     * タスクのロックを取得
     *
     * @param  Model  $target  ロック対象（Cluster、Spot、ModelPlan）
     * @param  string  $taskType  タスクタイプ（spot_listing, detail, catchphrase, model_plan など）
     * @param  AiModel  $model  使用するAIモデル
     * @return bool ロック取得に成功した場合true
     *
     * @throws ConcurrentAnalysisException ロック取得に失敗した場合
     */
    public function acquireLock(Model $target, string $taskType, AiModel $model): bool
    {
        // ロックが既に取得されていないか確認
        $this->validateLockAvailable($target, $taskType);

        // ロックカラムを設定
        $analyzingByColumn = $this->getAnalyzingByColumn($taskType);
        $analyzingStartedAtColumn = $this->getAnalyzingStartedAtColumn($taskType);

        // 楽観的ロックで更新（analyzed_byがnullであることを条件とする）
        $analyzedByColumn = $this->getAnalyzedByColumn($taskType);

        $updated = $target->newQuery()
            ->where('id', $target->id)
            ->whereNull($analyzingByColumn)
            ->whereNull($analyzedByColumn) // まだ分析完了していないこと
            ->update([
                $analyzingByColumn => $model->id,
                $analyzingStartedAtColumn => now(),
            ]);

        if ($updated === 0) {
            // 他のワーカーが先にロックを取得した
            throw new ConcurrentAnalysisException(
                "Failed to acquire lock for {$taskType} on {$target->getTable()}:{$target->id}"
            );
        }

        // モデルの状態を更新
        $target->refresh();

        return true;
    }

    /**
     * タスクのロックを解放（分析完了時）
     *
     * @param  Model  $target  ロック対象（Cluster、Spot、ModelPlan）
     * @param  string  $taskType  タスクタイプ
     * @param  AiModel  $model  使用したAIモデル
     */
    public function releaseLock(Model $target, string $taskType, AiModel $model): void
    {
        $analyzingByColumn = $this->getAnalyzingByColumn($taskType);
        $analyzingStartedAtColumn = $this->getAnalyzingStartedAtColumn($taskType);
        $analyzedByColumn = $this->getAnalyzedByColumn($taskType);

        $target->update([
            $analyzedByColumn => $model->id,
            $analyzingByColumn => null,
            // analyzing_started_at は実行履歴として保持（クリアしない）
        ]);
    }

    /**
     * タスクのロックを強制解放（エラー時など）
     *
     * @param  Model  $target  ロック対象
     * @param  string  $taskType  タスクタイプ
     */
    public function forceReleaseLock(Model $target, string $taskType): void
    {
        $analyzingByColumn = $this->getAnalyzingByColumn($taskType);
        $analyzingStartedAtColumn = $this->getAnalyzingStartedAtColumn($taskType);

        $target->update([
            $analyzingByColumn => null,
            // analyzing_started_at は実行履歴として保持（クリアしない）
        ]);
    }

    /**
     * ロックが取得可能かを検証
     *
     * @throws ConcurrentAnalysisException ロックが既に取得されている場合
     */
    private function validateLockAvailable(Model $target, string $taskType): void
    {
        $analyzingByColumn = $this->getAnalyzingByColumn($taskType);
        $analyzingStartedAtColumn = $this->getAnalyzingStartedAtColumn($taskType);
        $lockTimeoutMinutes = config('ai.task_selection.task_lock_timeout_minutes', 30);

        // 既にロックが取得されているかチェック
        if ($target->{$analyzingByColumn} !== null) {
            $startedAt = $target->{$analyzingStartedAtColumn};

            // タイムアウトチェック
            if ($startedAt && now()->diffInMinutes($startedAt) > $lockTimeoutMinutes) {
                // タイムアウトしているので強制解放
                $this->forceReleaseLock($target, $taskType);

                return;
            }

            throw new ConcurrentAnalysisException(
                "Lock already acquired for {$taskType} on {$target->getTable()}:{$target->id}"
            );
        }

        // 既に分析完了しているかチェック
        $analyzedByColumn = $this->getAnalyzedByColumn($taskType);
        if ($target->{$analyzedByColumn} !== null) {
            throw new ConcurrentAnalysisException(
                "Analysis already completed for {$taskType} on {$target->getTable()}:{$target->id}"
            );
        }
    }

    /**
     * タスクタイプからカラム名を生成: {task_type}_analyzing_by_model_id
     */
    private function getAnalyzingByColumn(string $taskType): string
    {
        // spotの場合は detail_analyzing_by_model_id
        // clusterの場合は spot_listing_analyzing_by_model_id など
        if ($taskType === 'detail') {
            return 'detail_analyzing_by_model_id';
        }

        return "{$taskType}_analyzing_by_model_id";
    }

    /**
     * タスクタイプからカラム名を生成: {task_type}_analyzing_started_at
     */
    private function getAnalyzingStartedAtColumn(string $taskType): string
    {
        if ($taskType === 'detail') {
            return 'detail_analyzing_started_at';
        }

        return "{$taskType}_analyzing_started_at";
    }

    /**
     * タスクタイプからカラム名を生成: {task_type}_analyzed_by_model_id
     */
    private function getAnalyzedByColumn(string $taskType): string
    {
        if ($taskType === 'detail') {
            return 'detail_analyzed_by_model_id';
        }

        return "{$taskType}_analyzed_by_model_id";
    }

    /**
     * タイムアウトしたロックを一括解放
     *
     * @param  string  $modelClass  モデルクラス（Cluster::class または Spot::class）
     * @param  string  $taskType  タスクタイプ
     * @return int 解放したロック数
     */
    public function releaseTimedOutLocks(string $modelClass, string $taskType): int
    {
        $lockTimeoutMinutes = config('ai.task_selection.task_lock_timeout_minutes', 30);
        $analyzingByColumn = $this->getAnalyzingByColumn($taskType);
        $analyzingStartedAtColumn = $this->getAnalyzingStartedAtColumn($taskType);

        return $modelClass::whereNotNull($analyzingByColumn)
            ->where($analyzingStartedAtColumn, '<', now()->subMinutes($lockTimeoutMinutes))
            ->update([
                $analyzingByColumn => null,
                // analyzing_started_at は実行履歴として保持（クリアしない）
            ]);
    }
}
