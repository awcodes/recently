<?php

declare(strict_types=1);

namespace Awcodes\Recently\Resources;

use Awcodes\Recently\RecentlyPlugin;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RecentEntryResource extends Resource
{
    protected static ?string $model = null;

    protected static ?string $recordTitleAttribute = 'title';

    protected static bool $shouldRegisterNavigation = false;

    public static function getModel(): string
    {
        return config('recently.model');
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->existing();
    }

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
