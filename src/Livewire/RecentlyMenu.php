<?php

namespace Awcodes\Recently\Livewire;

use Awcodes\Recently\Models\RecentEntry;
use Awcodes\Recently\RecentlyPlugin;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class RecentlyMenu extends Component
{
    public ?Collection $records = null;

    public ?bool $rounded = null;

    public ?string $label = null;

    public ?string $tooltip = null;

    public ?string $icon = null;

    public ?string $width = null;

    public function mount(): void
    {
        $plugin = RecentlyPlugin::get();

        $this->records = RecentEntry::query()
            ->orderByDesc('updated_at')
            ->limit($plugin->getMaxItems())
            ->get();
        $this->rounded = $plugin->isRounded();
        $this->label = $plugin->getLabel();
        $this->tooltip = $plugin->gettooltip();
        $this->icon = $plugin->getIcon();
        $this->width = $plugin->getWidth();
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
