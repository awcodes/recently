<?php

declare(strict_types=1);

namespace Awcodes\Recently\Tests\Resources\Pages\Pages;

use Awcodes\Recently\Concerns\HasRecentHistoryRecorder;
use Awcodes\Recently\Tests\Resources\Pages\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

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
