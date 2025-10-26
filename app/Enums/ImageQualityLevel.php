<?php

namespace App\Enums;

enum ImageQualityLevel: string{
    case ManuallyVerifiedPhoto = "manually_verified_photo";
    case AiGeneric = "ai_generic";

    public static function options(): array{
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [$case->value])
            ->all();
    }
}
