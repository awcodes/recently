<?php

declare(strict_types=1);

namespace Awcodes\Recently;

use BackedEnum;
use Filament\Facades\Filament;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

class Recently
{
    public function add(string $url, string|BackedEnum|null $icon, string $title, ?Model $record = null): void
    {
        if ($icon instanceof Heroicon) {
            $icon = "heroicon-$icon->value";
        }

        /** @var class-string<Model> $model */
        $model = config('recently.model');

        $model::updateOrCreate([
            'user_id' => Filament::auth()->user()->getAuthIdentifier(),
            'url' => $url,
        ], [
            'user_id' => Filament::auth()->user()->getAuthIdentifier(),
            'url' => $url,
            'icon' => $icon ?? '',
            'title' => $title,
            'recordable_type' => $record?->getMorphClass(),
            'recordable_id' => $record?->getKey(),
        ]);
    }
}
