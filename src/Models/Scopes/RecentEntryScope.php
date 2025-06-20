<?php

declare(strict_types=1);

namespace Awcodes\Recently\Models\Scopes;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class RecentEntryScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (Filament::auth()->check()) {
            $builder->where('user_id', Filament::auth()->user()->getAuthIdentifier());
        }
    }
}
