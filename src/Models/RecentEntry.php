<?php

declare(strict_types=1);

namespace Awcodes\Recently\Models;

use Awcodes\Recently\Database\Factories\RecentEntryFactory;
use Awcodes\Recently\Models\Scopes\RecentEntryScope;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
    use MassPrunable;

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
     * Entries without a record reference are always kept. Entries whose
     * morph type no longer resolves to a class can't point at a live record,
     * so they're excluded rather than passed to whereHasMorph(), which
     * would fail instantiating them.
     */
    public function scopeWhereRecordExists(Builder $query): void
    {
        $types = $this->newQuery()
            ->whereNotNull('recordable_type')
            ->distinct()
            ->pluck('recordable_type')
            ->filter(fn (string $type): bool => class_exists(Relation::getMorphedModel($type) ?? $type))
            ->values()
            ->all();

        $query->where(function (Builder $query) use ($types): void {
            $query->whereNull('recordable_type');

            if ($types !== []) {
                $query->orWhereHasMorph(
                    'recordable',
                    $types,
                    fn (Builder $query) => $query->when(
                        config('recently.include_trashed_records', false),
                        fn (Builder $query) => $query->withoutGlobalScope(SoftDeletingScope::class),
                    ),
                );
            }
        });
    }

    public function prunable(): Builder
    {
        $days = config('recently.prune_after_days');

        if (blank($days)) {
            return static::query()->whereRaw('1 = 0');
        }

        return static::query()->where('updated_at', '<', now()->subDays((int) $days));
    }

    protected static function newFactory(): RecentEntryFactory
    {
        return new RecentEntryFactory;
    }
}
