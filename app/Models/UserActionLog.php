<?php

namespace App\Models;

use App\Enums\UserActionType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserActionLog extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'session_id',
        'user_id',
        'action_type',
        'target_type',
        'target_id',
    ];

    protected function casts(): array
    {
        return [
            'action_type' => UserActionType::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function target(): MorphTo
    {
        return $this->morphTo();
    }
}
