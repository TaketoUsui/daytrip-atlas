<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class SuggestionSetItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "suggestion_set_id",
        "cluster_id",
        "key_visual_image_id",
        "catchphrase_id",
        "model_plan_id",
        "display_order",
        "generated_travel_time_text",
    ];

    protected $casts = [
        "display_order" => "integer",
    ];

    protected static function booted(): void
    {
        static::creating(function (self $item) {
            $item->uuid = $item->uuid ?? (string) Str::uuid();
        });
    }

    public function getRouteKeyName(): string{
        return "uuid";
    }

    public function suggestionSet(): BelongsTo{
        return $this->belongsTo(SuggestionSet::class);
    }

    public function cluster(): BelongsTo{
        return $this->belongsTo(Cluster::class);
    }

    public function keyVisualImage(): BelongsTo{
        return $this->belongsTo(Image::class, 'key_visual_image_id');
    }

    public function catchphrase(): BelongsTo{
        return $this->belongsTo(Catchphrase::class);
    }

    public function modelPlan(): BelongsTo{
        return $this->belongsTo(ModelPlan::class);
    }
}
