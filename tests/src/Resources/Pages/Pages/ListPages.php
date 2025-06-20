<?php

declare(strict_types=1);

namespace Awcodes\Recently\Tests\Resources\Pages\Pages;

use Awcodes\Recently\Tests\Resources\Pages\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
