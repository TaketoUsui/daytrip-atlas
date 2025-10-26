<?php

namespace App\Enums;

enum SuggestionStatus: string{
    case Pending = 'pending';
    case ProcessingClusters = 'processing_clusters';
    case AnalyzingItems = 'analyzing_items';
    case Complete = 'complete';
    case Failed = 'failed';

    public static function options(): array{
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [$case->value])
            ->all();
    }
}
