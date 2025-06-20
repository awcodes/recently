<?php

declare(strict_types=1);

namespace Awcodes\Recently\Tests\Resources\Pages\Schemas;

use Exception;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PageForm
{
    /** @throws Exception */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                TextInput::make('title'),
                TextInput::make('slug'),
                RichEditor::make('content'),
            ]);
    }
}
