<?php

declare(strict_types=1);

// config for Awcodes/Recently
return [
    'model' => Awcodes\Recently\Models\RecentEntry::class,
    'user_model' => App\Models\User::class,
    'max_items' => 20,
    'width' => 'xs',
    'global_search' => true,
    'menu' => true,
    'icon' => 'heroicon-o-arrow-uturn-left',
    'max_stored_items' => null,
    'prune_after_days' => null,
    'track_records' => false,
    'include_trashed_records' => false,
];
