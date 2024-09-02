<?php

namespace Awcodes\Recently\Resources;

use Awcodes\Recently\Models\RecentEntry;
use Awcodes\Recently\RecentlyPlugin;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

class RecentEntryResource extends Resource
{
    protected static ?string $model = RecentEntry::class;

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
