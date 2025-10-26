<?php

namespace App\Models;

use App\Enums\UserSpotInterestStatus;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserSpotInterest extends Pivot
{
    protected $table = 'user_spot_interests';

    public $incrementing = false;

    const UPDATED_AT = null;

    protected function casts(){
        return [
            "status" => UserSpotInterestStatus::class,
        ];
    }
}
