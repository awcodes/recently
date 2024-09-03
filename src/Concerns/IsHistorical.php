<?php

namespace Awcodes\Recently\Concerns;

use Awcodes\Recently\Facades\Recently;
use Filament\Facades\Filament;
use Illuminate\Support\Str;

trait IsHistorical
{
    public function renderedIsHistorical(): void
    {
        $panel = Filament::getCurrentPanel();

        match(true) {
            Str::contains(request()->fullUrl(), $panel->getPath()) => $this->recordHistory(),
            $panel->isDefault() && blank($panel->getPath()) => $this->recordHistory(),
            default => null,
        };
    }

    protected function recordHistory(): void
    {
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
