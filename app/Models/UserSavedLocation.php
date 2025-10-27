<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property float $latitude
 * @property float $longitude
 * @property string|null $address
 * @property Carbon|null $created_at
 * @property-read User $user
 * @method static Builder<static>|UserSavedLocation newModelQuery()
 * @method static Builder<static>|UserSavedLocation newQuery()
 * @method static Builder<static>|UserSavedLocation query()
 * @method static Builder<static>|UserSavedLocation whereAddress($value)
 * @method static Builder<static>|UserSavedLocation whereCreatedAt($value)
 * @method static Builder<static>|UserSavedLocation whereId($value)
 * @method static Builder<static>|UserSavedLocation whereLatitude($value)
 * @method static Builder<static>|UserSavedLocation whereLongitude($value)
 * @method static Builder<static>|UserSavedLocation whereName($value)
 * @method static Builder<static>|UserSavedLocation whereUserId($value)
 * @mixin Eloquent
 */
class UserSavedLocation extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'name',
        'latitude',
        'longitude',
        'address',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
