<?php

namespace App\Models;

use App\Data\InputTagsData;
use App\Data\ProcessingDetailsData;
use App\Enums\SuggestionStatus;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\LaravelData\WithData;

/**
 * @property int $id
 * @property string $uuid
 * @property string $session_id
 * @property int|null $user_id
 * @property SuggestionStatus $status
 * @property ProcessingDetailsData|null $processing_details
 * @property float $input_latitude
 * @property float $input_longitude
 * @property InputTagsData|null $input_tags_json
 * @property Carbon|null $created_at
 * @property-read Collection<int, SuggestionSetItem> $items
 * @property-read int|null $items_count
 * @property-read User|null $user
 * @method static Builder<static>|SuggestionSet newModelQuery()
 * @method static Builder<static>|SuggestionSet newQuery()
 * @method static Builder<static>|SuggestionSet query()
 * @method static Builder<static>|SuggestionSet whereCreatedAt($value)
 * @method static Builder<static>|SuggestionSet whereId($value)
 * @method static Builder<static>|SuggestionSet whereInputLatitude($value)
 * @method static Builder<static>|SuggestionSet whereInputLongitude($value)
 * @method static Builder<static>|SuggestionSet whereInputTagsJson($value)
 * @method static Builder<static>|SuggestionSet whereProcessingDetails($value)
 * @method static Builder<static>|SuggestionSet whereSessionId($value)
 * @method static Builder<static>|SuggestionSet whereStatus($value)
 * @method static Builder<static>|SuggestionSet whereUserId($value)
 * @method static Builder<static>|SuggestionSet whereUuid($value)
 * @mixin Eloquent
 */
class SuggestionSet extends Model
{
    use WithData;

    const UPDATED_AT = null;

    protected $fillable = [
        "session_id",
        "user_id",
        "status",
        "processing_details",
        "input_latitude",
        "input_longitude",
        "input_tags_json",
    ];

    protected function casts(): array
    {
        return [
            "status" => SuggestionStatus::class,
            "processing_details" => ProcessingDetailsData::class,
            "input_tags_json" => InputTagsData::class,
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
