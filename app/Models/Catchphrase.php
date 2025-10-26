<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Catchphrase extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        "content",
        "source_analysis",
        "performance_score",
    ];

    protected $casts = [
        "source_analysis" => "array",
        "performance_score" => "integer",
    ];

    public function suggestionSetItems(): HasMany{
        return $this->hasMany(SuggestionSetItem::class);
    }
}
