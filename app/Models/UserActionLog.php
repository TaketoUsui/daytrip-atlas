<?php

namespace App\Models;

use App\Enums\UserActionType;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $session_id
 * @property int|null $user_id
 * @property UserActionType $action_type
 * @property string $target_type
 * @property int $target_id
 * @property Carbon|null $created_at
 * @property-read Model|Eloquent $target
 * @property-read User|null $user
 * @method static Builder<static>|UserActionLog newModelQuery()
 * @method static Builder<static>|UserActionLog newQuery()
 * @method static Builder<static>|UserActionLog query()
 * @method static Builder<static>|UserActionLog whereActionType($value)
 * @method static Builder<static>|UserActionLog whereCreatedAt($value)
 * @method static Builder<static>|UserActionLog whereId($value)
 * @method static Builder<static>|UserActionLog whereSessionId($value)
 * @method static Builder<static>|UserActionLog whereTargetId($value)
 * @method static Builder<static>|UserActionLog whereTargetType($value)
 * @method static Builder<static>|UserActionLog whereUserId($value)
 * @mixin Eloquent
 */
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
