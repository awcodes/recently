<?php

namespace Awcodes\Recently\Models;

use Awcodes\Recently\Database\Factories\RecentEntryFactory;
use Awcodes\Recently\Models\Scopes\RecentEntryScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected static function newFactory(): RecentEntryFactory
    {
        return new RecentEntryFactory;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('recently.user_model'));
    }
}
