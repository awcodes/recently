<?php

declare(strict_types=1);

namespace Awcodes\Recently\Tests\Resources\Pages;

use Awcodes\Recently\Tests\Models\Page;
use Awcodes\Recently\Tests\Resources\Pages\Schemas\PageForm;
use Awcodes\Recently\Tests\Resources\Pages\Tables\PagesTable;
use Exception;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    /** @throws Exception */
    public static function form(Schema $schema): Schema
    {
        return PageForm::configure($schema);
    }

    /** @throws Exception */
    public static function table(Table $table): Table
    {
        return PagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
