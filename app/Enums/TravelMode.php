<?php

namespace App\Enums;

enum TravelMode: string{
    case Walk = "walk";
    case Car = "car";
    case Train = "train";
    case Bus = "bus";

    public static function options(): array{
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [$case->value])
            ->all();
    }
}
