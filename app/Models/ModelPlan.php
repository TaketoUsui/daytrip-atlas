<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModelPlan extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        "cluster_id",
        "name",
        "description",
        "total_duration_minutes",
        "is_default",
    ];

    protected function casts()
    {
        return [
            "total_duration_minutes" => "integer",
            "is_default" => "boolean",
        ];
    }

    public function cluster(): BelongsTo{
        return $this->belongsTo(Cluster::class);
    }

    public function suggestionSetItems(): HasMany{
        return $this->hasMany(SuggestionSetItem::class);
    }

    public function items(): HasMany{
        return $this->hasMany(ModelPlanItem::class)->orderBy("display_order");
    }
}
