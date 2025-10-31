<?php

namespace App\Enums;

enum TravelMode: string{
    case Walk = "walk";
    case Car = "car";
    case Train = "train";
    case Bus = "bus";
    case Other = "other";

    public static function options(): array{
        return collect(self::cases())
            ->map(fn(self $case) => [$case->value])
            ->all();
    }

    public static function fromJapanese(string $value): self
    {
        return match (trim($value)) {
            '徒歩' => self::Walk,
            'バス' => self::Bus,
            '車' => self::Car,
            '電車' => self::Train,
            // プロンプト 以外の値が来た場合のフォールバック
            default => self::Other,
        };
    }
}
