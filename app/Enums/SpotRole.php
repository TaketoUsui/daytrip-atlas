<?php

namespace App\Enums;

enum SpotRole: string{
    case MainDestination = "main_destination";
    case SubDestination = "sub_destination";
    case ConnectorSpot = "connector_spot";

    public static function options(): array{
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [$case->value])
            ->all();
    }
}
