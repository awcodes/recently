<?php

namespace Awcodes\Recently\Livewire;

use Awcodes\Recently\Models\RecentEntry;
use Awcodes\Recently\RecentlyPlugin;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class RecentlyMenu extends Component
{
    #[Computed]
    public ?Collection $records = null;

    public ?string $icon = null;

    public ?string $label = null;

    public ?int $maxItems = null;

    public ?bool $rounded = null;

    public ?string $tooltip = null;

    public MaxWidth | null | string $width = null;

    public function mount(): void
    {
        $plugin = RecentlyPlugin::get();

        $this->rounded = $plugin->isRounded();
        $this->label = $plugin->getLabel();
        $this->tooltip = $plugin->gettooltip();
        $this->icon = $plugin->getIcon();
        $this->width = $plugin->getWidth();
        $this->maxItems = $plugin->getMaxItems();

        $this->getRecords();
    }

    #[On('livewire:navigated')]
    public function getRecords(): void
    {
        $this->records = RecentEntry::query()
            ->orderByDesc('updated_at')
            ->limit($this->maxItems)
            ->get();
    }

    public function clearRecords(): void
    {
        RecentEntry::query()->delete();
        $this->records = null;
    }

    public function render(): View
    {
        return view('recently::components.recently-menu');
    }
}
