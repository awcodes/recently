<?php

declare(strict_types=1);

namespace Workbench\App\Filament\Resources\Pages\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Workbench\App\Filament\Resources\Pages\PageResource;

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
