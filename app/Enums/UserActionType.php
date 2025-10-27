<?php

namespace App\Enums;

enum UserActionType: string{
    case Impression = 'impression';
    case ViewClusterDetail = 'view_cluster_detail';
    case ClickSpotLink = 'click_spot_link';
    case ClickAffiliateLink = 'click_affiliate_link';

    public static function options(): array{
        return collect(self::cases())
            ->map(fn(self $case) => [$case->value])
            ->all();
    }
}
