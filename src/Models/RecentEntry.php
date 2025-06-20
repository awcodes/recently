<?php

declare(strict_types=1);

namespace Awcodes\Recently\Models;

use Awcodes\Recently\Database\Factories\RecentEntryFactory;
use Awcodes\Recently\Models\Scopes\RecentEntryScope;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read int $user_id
 * @property string $url
 * @property string|null $icon
 * @property string|null $title
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
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('recently.user_model'));
    }

    protected static function newFactory(): RecentEntryFactory
    {
        return new RecentEntryFactory;
    }
}
