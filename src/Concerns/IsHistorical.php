<?php

namespace Awcodes\Recently\Concerns;

use Awcodes\Recently\Facades\Recently;

trait IsHistorical
{
    public function renderedIsHistorical(): void
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
