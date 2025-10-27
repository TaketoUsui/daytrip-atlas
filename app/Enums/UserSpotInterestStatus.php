<?php

namespace App\Enums;

enum UserSpotInterestStatus: string{
    case Interested = "interested";
    case Dismissed = "dismissed";

    public static function options(): array{
        return collect(self::cases())
            ->map(fn(self $case) => [$case->value])
            ->all();
    }
}
