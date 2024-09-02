<?php

namespace Awcodes\Recently\Concerns;

use Awcodes\Recently\Facades\Recently;
use Filament\Facades\Filament;
use Illuminate\Support\Str;

trait IsHistorical
{
    public function renderedIsHistorical(): void
    {
        if (Str::contains(request()->fullUrl(), Filament::getCurrentPanel()->getPath())) {
            $resource = static::getResource();
            $record = $this->getRecord();
            $title = $this->getTitle($record);

            if (! $resource::getRecordTitleAttribute()) {
                $title .= ' ' . $record->id;
            }

            Recently::add(
                url: request()->fullUrl(),
                icon: $resource::getNavigationIcon(),
                title: $title,
            );
        }
    }
}
