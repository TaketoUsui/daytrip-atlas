<?php

namespace App\Data;

use Spatie\LaravelData\Data;

/**
 * UserProfile.preferences のスキーマ定義
 *
 * ユーザーの各種設定や好みを保存します。
 * 将来的な拡張性を考慮して、任意の追加プロパティを許容します。
 */
class UserPreferencesData extends Data
{
    public function __construct(
        // 現在は具体的なフィールドなし（将来の拡張用）
        // 例: public ?string $preferredTransportation = null,
        // 例: public ?array $favoriteCategories = null,
    ) {}

    /**
     * 任意の追加プロパティを許容する設定
     */
    public static function allowAdditionalProperties(): bool
    {
        return true;
    }
}
