<?php

namespace App\Models;

use App\Enums\UserSpotInterestStatus;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * @property int $user_id
 * @property int $spot_id
 * @property UserSpotInterestStatus $status
 * @property Carbon $created_at
 * @method static Builder<static>|UserSpotInterest newModelQuery()
 * @method static Builder<static>|UserSpotInterest newQuery()
 * @method static Builder<static>|UserSpotInterest query()
 * @method static Builder<static>|UserSpotInterest whereCreatedAt($value)
 * @method static Builder<static>|UserSpotInterest whereSpotId($value)
 * @method static Builder<static>|UserSpotInterest whereStatus($value)
 * @method static Builder<static>|UserSpotInterest whereUserId($value)
 * @mixin Eloquent
 */
class UserSpotInterest extends Pivot
{
    protected $table = 'user_spot_interests';

    public $incrementing = false;

    const UPDATED_AT = null;

    protected function casts(): array{
        return [
            "status" => UserSpotInterestStatus::class,
        ];
    }
}
