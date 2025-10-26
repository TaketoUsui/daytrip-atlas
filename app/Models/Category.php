<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = [
        "name",
    ];

    public function spots(): BelongsToMany{
        return $this->belongsToMany(Spot::class, "spot_category");
    }
}
