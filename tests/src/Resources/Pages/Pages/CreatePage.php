<?php

declare(strict_types=1);

namespace Awcodes\Recently\Tests\Resources\Pages\Pages;

use Awcodes\Recently\Tests\Resources\Pages\PageResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;
}
