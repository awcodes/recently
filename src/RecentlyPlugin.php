<?php

namespace Awcodes\Recently;

use Awcodes\Recently\Livewire\RecentlyMenu;
use Awcodes\Recently\Resources\RecentEntryResource;
use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Support\Enums\MaxWidth;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;

class RecentlyPlugin implements Plugin
{
    use EvaluatesClosures;

    protected string | Closure | null $renderUsingHook = null;

    protected bool | Closure | null $rounded = null;

    protected string | Closure | null $label = null;

    protected string | Closure | null $tooltip = null;

    protected string | Closure | null $icon = null;

    protected MaxWidth | string | Closure | null $width = null;

    protected int | Closure | null $maxItems = null;

    protected bool | Closure | null $hasGlobalSearch = null;

    protected bool | Closure | null $hasMenu = null;

    public function getId(): string
    {
        return 'awcodes/recently';
    }

    public function register(Panel $panel): void
    {
        if ($this->hasMenu()) {
            Livewire::component('recently', RecentlyMenu::class);

            $panel
                ->renderHook(
                    name: $this->getRenderHook(),
                    hook: fn () => Blade::render('<livewire:recently />')
                );
        }

        if ($this->hasGlobalSearch()) {
            $panel
                ->resources([
                    RecentEntryResource::class,
                ]);
        }
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function globalSearch(bool | Closure $condition = true): static
    {
        $this->hasGlobalSearch = $condition;

        return $this;
    }

    public function menu(bool | Closure $condition = true): static
    {
        $this->hasMenu = $condition;

        return $this;
    }

    public function icon(string | Closure $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function label(string | Closure $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function tooltip(string | Closure $tooltip): static
    {
        $this->tooltip = $tooltip;

        return $this;
    }

    public function maxItems(int | Closure $maxItems): static
    {
        $this->maxItems = $maxItems;

        return $this;
    }

    public function width(MaxWidth | string | Closure $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function renderUsingHook(string | Closure $panelHook): static
    {
        $this->renderUsingHook = $panelHook;

        return $this;
    }

    public function rounded(bool | Closure $condition = true): static
    {
        $this->rounded = $condition;

        return $this;
    }

    public function getIcon(): string
    {
        return $this->evaluate($this->icon) ?? config('recently.icon');
    }

    public function getLabel(): ?string
    {
        return $this->evaluate($this->label) ?? null;
    }

    public function getTooltip(): ?string
    {
        return $this->evaluate($this->tooltip) ?? null;
    }

    public function getMaxItems(): int
    {
        return $this->evaluate($this->maxItems) ?? config('recently.max_items');
    }

    public function getWidth(): MaxWidth | string
    {
        return $this->evaluate($this->width) ?? config('recently.width');
    }

    public function getRenderHook(): string
    {
        return $this->evaluate($this->renderUsingHook) ?? PanelsRenderHook::USER_MENU_BEFORE;
    }

    public function hasGlobalSearch(): bool
    {
        return $this->evaluate($this->hasGlobalSearch) ?? config('recently.global_search');
    }

    public function hasMenu(): bool
    {
        return $this->evaluate($this->hasMenu) ?? config('recently.menu');
    }

    public function isRounded(): bool
    {
        return $this->evaluate($this->rounded) ?? true;
    }
}
