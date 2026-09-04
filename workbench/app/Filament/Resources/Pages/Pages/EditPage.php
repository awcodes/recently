<?php

declare(strict_types=1);

namespace Workbench\App\Filament\Resources\Pages\Pages;

use Awcodes\Recently\Concerns\HasRecentHistoryRecorder;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Workbench\App\Filament\Resources\Pages\PageResource;

class EditPage extends EditRecord
{
    use HasRecentHistoryRecorder;

    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
