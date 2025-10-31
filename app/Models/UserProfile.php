<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $user_id
 * @property array<array-key, mixed>|null $preferences
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder<static>|UserProfile newModelQuery()
 * @method static Builder<static>|UserProfile newQuery()
 * @method static Builder<static>|UserProfile query()
 * @method static Builder<static>|UserProfile wherePreferences($value)
 * @method static Builder<static>|UserProfile whereUpdatedAt($value)
 * @method static Builder<static>|UserProfile whereUserId($value)
 * @mixin Eloquent
 */
class UserProfile extends Model
{
    protected $primaryKey = 'user_id';

    public $incrementing = false;

    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'preferences',
    ];

    protected function casts(): array
    {
        return [
            'preferences' => 'array',
        ];
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
