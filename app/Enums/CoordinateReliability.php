<?php

namespace App\Enums;

enum CoordinateReliability: string{
    case ManuallyVerified = "manually_verified";
    case OpenDataSourced = "open_data_sourced";
    case LlmEstimated = "llm_estimated";

    public static function options(): array{
        return collect(self::cases())
            ->map(fn(self $case) => [$case->value])
            ->all();
    }
}
