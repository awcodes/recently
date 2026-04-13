<?php

declare(strict_types=1);

namespace Awcodes\Recently\Resources;

use Awcodes\Recently\RecentlyPlugin;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

class RecentEntryResource extends Resource
{
    protected static ?string $model = null;

    public static function getModel(): string
    {
        return config('recently.model');
    }

    protected static ?string $recordTitleAttribute = 'title';

    protected static bool $shouldRegisterNavigation = false;

    public static function getGlobalSearchResultUrl(Model $record): ?string
    {
        return $record->url;
    }

    public static function getGlobalSearchResultsLimit(): int
    {
        return RecentlyPlugin::get()->getMaxItems();
    }

    public static function getPluralModelLabel(): string
    {
        return __('recently::recently.global_search_label');
    }
}
