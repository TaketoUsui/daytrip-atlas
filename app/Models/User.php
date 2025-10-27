<?php

namespace App\Models;

use App\Enums\UserSpotInterestStatus;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, UserActionLog> $actionLogs
 * @property-read int|null $action_logs_count
 * @property-read UserSpotInterest|null $pivot
 * @property-read Collection<int, Spot> $interestedSpots
 * @property-read int|null $interested_spots_count
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read UserProfile|null $profile
 * @property-read Collection<int, UserSavedLocation> $savedLocations
 * @property-read int|null $saved_locations_count
 * @property-read Collection<int, Spot> $spotInterests
 * @property-read int|null $spot_interests_count
 * @property-read Collection<int, SuggestionSet> $suggestionSets
 * @property-read int|null $suggestion_sets_count
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereEmail($value)
 * @method static Builder<static>|User whereEmailVerifiedAt($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereName($value)
 * @method static Builder<static>|User wherePassword($value)
 * @method static Builder<static>|User whereRememberToken($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void{
        static::creating(function (User $user) {
            $user->uuid = $user->uuid ?? (string) Str::uuid();
        });
    }

    public function getRouteKeyName(): string{
        return 'uuid';
    }

    public function profile(): HasOne{
        return $this->hasOne(UserProfile::class);
    }

    public function savedLocations(): HasMany{
        return $this->hasMany(UserSavedLocation::class);
    }

    public function actionLogs(): HasMany{
        return $this->hasMany(UserActionLog::class);
    }

    public function suggestionSets(): HasMany{
        return $this->hasMany(SuggestionSet::class);
    }

    public function spotInterests(): BelongsToMany{
        return $this->belongsToMany(Spot::class, 'user_spot_interests')
            ->using(UserSpotInterest::class)
            ->withPivot("status", "created_at");
    }

    public function interestedSpots(): BelongsToMany{
        return $this->spotInterests()
            ->wherePivot("status", UserSpotInterestStatus::Interested);
    }

    public function dismissedSpots(): HasMany{
        return $this->spotInterests()
            ->wherePivot("status", UserSpotInterestStatus::Dismissed);
    }
}
