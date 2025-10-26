<?php

namespace App\Models;

use App\Enums\UserSpotInterestStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
