<?php

declare(strict_types=1);

namespace Awcodes\Recently;

use Awcodes\Recently\Models\RecentEntry;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Support\Icons\Heroicon;

class Recently
{
    public function add(string $url, string|BackedEnum|null $icon, string $title): void
    {
        if ($icon instanceof Heroicon) {
            $icon = "heroicon-$icon->value";
        }

        RecentEntry::updateOrCreate([
            'user_id' => Filament::auth()->user()->getAuthIdentifier(),
            'url' => $url,
        ], [
            'user_id' => Filament::auth()->user()->getAuthIdentifier(),
            'url' => $url,
            'icon' => $icon ?? '',
            'title' => $title,
        ]);
    }
}
