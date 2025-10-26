<?php

namespace App\Enums;

enum ClusterStatus: string{
    case Draft = 'draft';
    case Published = 'published';
    case Archived = 'archived';

    public static function options(): array{
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [$case->value])
            ->all();
    }
}
