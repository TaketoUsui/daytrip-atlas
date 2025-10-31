<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property-read Collection<int, Spot> $spots
 * @property-read int|null $spots_count
 * @method static Builder<static>|Category newModelQuery()
 * @method static Builder<static>|Category newQuery()
 * @method static Builder<static>|Category query()
 * @method static Builder<static>|Category whereId($value)
 * @method static Builder<static>|Category whereName($value)
 * @mixin Eloquent
 */
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
