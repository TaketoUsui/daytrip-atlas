<?php

namespace App\Services\AI;

use Carbon\Carbon;

/**
 * AI分析結果のキャッシュ管理サービス
 *
 * 各分析タイプのTTL（Time To Live）を管理し、再分析が必要かどうかを判定する
 */
class CacheManager
{
    /**
     * 指定された分析タイプのキャッシュTTL（秒）を取得
     */
    public function getTtl(string $analysisType): int
    {
        return config("ai.cache_ttl.{$analysisType}", 0);
    }

    /**
     * 分析結果が有効期限内かどうかを判定
     *
     * @param  string  $analysisType  分析タイプ (spot_listing, spot_priority, etc.)
     * @param  Carbon|string|null  $analyzedAt  分析完了日時
     * @return bool true: 有効期限内, false: 期限切れまたは未分析
     */
    public function isValid(string $analysisType, Carbon|string|null $analyzedAt): bool
    {
        if ($analyzedAt === null) {
            return false;
        }

        $ttl = $this->getTtl($analysisType);

        if ($ttl === 0) {
            // TTLが0の場合は常に無効（再分析が必要）
            return false;
        }

        $analyzedAt = $analyzedAt instanceof Carbon ? $analyzedAt : Carbon::parse($analyzedAt);
        $expiresAt = $analyzedAt->addSeconds($ttl);

        return now()->lessThan($expiresAt);
    }

    /**
     * 分析結果が期限切れかどうかを判定
     *
     * @param  string  $analysisType  分析タイプ
     * @param  Carbon|string|null  $analyzedAt  分析完了日時
     * @return bool true: 期限切れまたは未分析, false: 有効期限内
     */
    public function isExpired(string $analysisType, Carbon|string|null $analyzedAt): bool
    {
        return ! $this->isValid($analysisType, $analyzedAt);
    }

    /**
     * 有効期限が切れる日時を計算
     *
     * @param  string  $analysisType  分析タイプ
     * @param  Carbon|string|null  $analyzedAt  分析完了日時
     * @return Carbon|null 有効期限が切れる日時（未分析の場合はnull）
     */
    public function getExpiresAt(string $analysisType, Carbon|string|null $analyzedAt): ?Carbon
    {
        if ($analyzedAt === null) {
            return null;
        }

        $ttl = $this->getTtl($analysisType);

        if ($ttl === 0) {
            return null;
        }

        $analyzedAt = $analyzedAt instanceof Carbon ? $analyzedAt : Carbon::parse($analyzedAt);

        return $analyzedAt->copy()->addSeconds($ttl);
    }

    /**
     * 有効期限までの残り時間（秒）を取得
     *
     * @param  string  $analysisType  分析タイプ
     * @param  Carbon|string|null  $analyzedAt  分析完了日時
     * @return int|null 残り秒数（期限切れの場合は負の値、未分析の場合はnull）
     */
    public function getRemainingSeconds(string $analysisType, Carbon|string|null $analyzedAt): ?int
    {
        $expiresAt = $this->getExpiresAt($analysisType, $analyzedAt);

        if ($expiresAt === null) {
            return null;
        }

        return now()->diffInSeconds($expiresAt, false);
    }

    /**
     * 複数の分析タイプの有効性を一括チェック
     *
     * @param  array  $checks  ['analysis_type' => 'analyzed_at_value', ...]
     * @return bool すべての分析が有効期限内の場合true
     */
    public function areAllValid(array $checks): bool
    {
        foreach ($checks as $analysisType => $analyzedAt) {
            if (! $this->isValid($analysisType, $analyzedAt)) {
                return false;
            }
        }

        return true;
    }

    /**
     * 期限切れの分析タイプのリストを取得
     *
     * @param  array  $checks  ['analysis_type' => 'analyzed_at_value', ...]
     * @return array 期限切れの分析タイプのリスト
     */
    public function getExpiredTypes(array $checks): array
    {
        $expired = [];

        foreach ($checks as $analysisType => $analyzedAt) {
            if ($this->isExpired($analysisType, $analyzedAt)) {
                $expired[] = $analysisType;
            }
        }

        return $expired;
    }
}
