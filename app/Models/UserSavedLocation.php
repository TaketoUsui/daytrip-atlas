<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected function casts()
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
