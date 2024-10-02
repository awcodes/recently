<?php

// config for Awcodes/Recently
return [
    'user_model' => App\Models\User::class,
    'table_name' => 'recent_entries',
    'max_items' => 20,
    'width' => 'xs',
    'global_search' => true,
    'menu' => true,
    'icon' => 'heroicon-o-arrow-uturn-left',
];
