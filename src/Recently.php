<?php

namespace Awcodes\Recently;

use Awcodes\Recently\Models\RecentEntry;
use Filament\Facades\Filament;

class Recently
{
    public function add(string $url, string $icon, string $title): void
    {
        RecentEntry::updateOrCreate([
            'user_id' => Filament::auth()->user()->getAuthIdentifier(),
            'url' => $url,
        ], [
            'user_id' => Filament::auth()->user()->getAuthIdentifier(),
            'url' => $url,
            'icon' => $icon,
            'title' => $title,
        ]);
    }
}
