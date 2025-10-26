<?php

namespace App\Models;

use App\Enums\ImageQualityLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        "file_name",
        "storage_path",
        "alt_text",
        "copyright_holder",
        "image_quality_level",
    ];

    protected function casts()
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
