<?php

namespace Awcodes\Recently\Concerns;

use Awcodes\Recently\Facades\Recently;
use Filament\Facades\Filament;
use Illuminate\Support\Str;
use Livewire\LivewireManager;

trait HasRecentHistoryRecorder
{
    public function renderedHasRecentHistoryRecorder(): void
    {
        $panel = Filament::getCurrentPanel();

        if ($this->isLivewireRequest()) {
            return;
        }

        match (true) {
            Str::contains(request()->url(), $panel->getPath()) => $this->recordHistory(),
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
            url: request()->url(),
            icon: $resource::getNavigationIcon(),
            title: strip_tags($title),
        );
    }

    protected function isLivewireRequest(): bool
    {
        return class_exists(LivewireManager::class) && app(LivewireManager::class)->isLivewireRequest();
    }
}
