<?php

namespace App\Enums;

/**
 * 座標情報の信頼度レベル
 *
 * 座標データの出典と信頼性を示す
 */
enum CoordinateReliability: string
{
    case ManuallyVerified = 'manually_verified';
    case OpenDataSourced = 'open_data_sourced';
    case AiAnalysis = 'ai_analysis';

    public static function options(): array
    {
        return collect(self::cases())
            ->map(fn (self $case) => [$case->value])
            ->all();
    }

    /**
     * 信頼性レベルの説明を取得
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::ManuallyVerified => '手動確認済み（最も信頼性が高い）',
            self::OpenDataSourced => 'オープンデータ由来（信頼性が高い）',
            self::AiAnalysis => 'AI分析（非同期AI分析で取得）',
        };
    }
}
