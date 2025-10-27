<?php

namespace App\Models;

use App\Enums\ImageQualityLevel;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid
 * @property string $file_name
 * @property string $storage_path
 * @property string|null $alt_text
 * @property string|null $copyright_holder
 * @property ImageQualityLevel $image_quality_level
 * @property Carbon|null $created_at
 * @property-read Collection<int, Spot> $spots
 * @property-read int|null $spots_count
 * @property-read Collection<int, SuggestionSetItem> $suggestionSetItemsAsKeyVisual
 * @property-read int|null $suggestion_set_items_as_key_visual_count
 * @method static Builder<static>|Image newModelQuery()
 * @method static Builder<static>|Image newQuery()
 * @method static Builder<static>|Image query()
 * @method static Builder<static>|Image whereAltText($value)
 * @method static Builder<static>|Image whereCopyrightHolder($value)
 * @method static Builder<static>|Image whereCreatedAt($value)
 * @method static Builder<static>|Image whereFileName($value)
 * @method static Builder<static>|Image whereId($value)
 * @method static Builder<static>|Image whereImageQualityLevel($value)
 * @method static Builder<static>|Image whereStoragePath($value)
 * @method static Builder<static>|Image whereUuid($value)
 * @mixin Eloquent
 */
class Image extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        "file_name",
        "storage_path",
        "alt_text",
        "copyright_holder",
        "image_quality_level",
    ];

    protected function casts(): array
    {
        return [
            "image_quality_level" => ImageQualityLevel::class,
        ];
    }

    protected static function booted(): void{
        static::creating(function (self $image) {
            $image->uuid = $image->uuid ?? (string) Str::uuid();
        });
    }

    public function getRouteKeyName(): string{
        return "uuid";
    }

    public function suggestionSetItemsAsKeyVisual(): HasMany{
        return $this->hasMany(SuggestionSetItem::class, "key_visual_image_id");
    }

    public function spots(): BelongsToMany
    {
        return $this->belongsToMany(Spot::class, "spot_images")
            ->withPivot("display_order")
            ->orderBy("display_order");
    }
}
