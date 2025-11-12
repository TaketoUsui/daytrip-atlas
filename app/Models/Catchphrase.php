<?php

namespace App\Models;

use App\Data\SourceAnalysisData;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\WithData;

/**
 * @property int $id
 * @property string $content
 * @property SourceAnalysisData|null $source_analysis
 * @property int|null $performance_score
 * @property Carbon|null $created_at
 * @property-read Collection<int, SuggestionSetItem> $suggestionSetItems
 * @property-read int|null $suggestion_set_items_count
 *
 * @method static Builder<static>|Catchphrase newModelQuery()
 * @method static Builder<static>|Catchphrase newQuery()
 * @method static Builder<static>|Catchphrase query()
 * @method static Builder<static>|Catchphrase whereContent($value)
 * @method static Builder<static>|Catchphrase whereCreatedAt($value)
 * @method static Builder<static>|Catchphrase whereId($value)
 * @method static Builder<static>|Catchphrase wherePerformanceScore($value)
 * @method static Builder<static>|Catchphrase whereSourceAnalysis($value)
 *
 * @mixin Eloquent
 */
class Catchphrase extends Model
{
    use WithData;

    const UPDATED_AT = null;

    protected $fillable = [
        'content',
        'source_analysis',
        'performance_score',
    ];

    protected $casts = [
        'source_analysis' => SourceAnalysisData::class,
        'performance_score' => 'integer',
    ];

    public function suggestionSetItems(): HasMany
    {
        return $this->hasMany(SuggestionSetItem::class);
    }
}
