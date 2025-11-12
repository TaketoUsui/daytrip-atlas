<?php

namespace App\Enums;

/**
 * 座標の信頼性レベル
 *
 * AI生成時の座標精度を示す
 */
enum CoordinateReliability: string
{
    case High = 'high';
    case Medium = 'medium';
    case Low = 'low';

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
            self::High => '高精度（正確な施設の位置）',
            self::Medium => '中精度（エリアの中心付近）',
            self::Low => '低精度（おおよその位置）',
        };
    }
}
