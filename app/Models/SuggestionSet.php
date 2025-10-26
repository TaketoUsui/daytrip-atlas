<?php

namespace App\Models;

use App\Enums\SuggestionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class SuggestionSet extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        "session_id",
        "user_id",
        "status",
        "input_latitude",
        "input_longitude",
        "input_tags_json",
    ];

    protected function casts()
    {
        return [
            "status" => SuggestionStatus::class,
            "input_tags_json" => "array",
            "input_latitude" => "float",
            "input_longitude" => "float",
        ];
    }

    protected static function booted(): void{
        static::creating(function (self $suggestionSet) {
            $suggestionSet->uuid = $suggestionSet->uuid ?? (string) Str::uuid();
        });
    }

    public function getRouteKeyName(): string{
        return 'uuid';
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany{
        return $this->hasMany(SuggestionSetItem::class)->orderBy("display_order");
    }
}
