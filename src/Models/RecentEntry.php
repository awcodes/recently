<?php

declare(strict_types=1);

namespace Awcodes\Recently\Models;

use Awcodes\Recently\Database\Factories\RecentEntryFactory;
use Awcodes\Recently\Models\Scopes\RecentEntryScope;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property-read int $id
 * @property-read int $user_id
 * @property string $url
 * @property string|null $icon
 * @property string|null $title
 * @property string|null $recordable_type
 * @property int|string|null $recordable_id
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
#[ScopedBy(RecentEntryScope::class)]
class RecentEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'url',
        'icon',
        'title',
        'recordable_type',
        'recordable_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('recently.user_model'));
    }

    public function recordable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Limit to entries that still point at a live record — i.e. those with no
     * record reference (e.g. non-record pages), or whose referenced record
     * still exists. A soft-deleted or hard-deleted record fails the morph
     * existence check and is excluded.
     */
    public function scopeExisting(Builder $query): void
    {
        $query->where(function (Builder $query): void {
            $query
                ->whereNull('recordable_type')
                ->orWhereHasMorph('recordable', '*');
        });
    }

    protected static function newFactory(): RecentEntryFactory
    {
        return new RecentEntryFactory;
    }
}
