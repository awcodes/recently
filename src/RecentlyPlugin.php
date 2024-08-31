<?php

namespace Awcodes\Recently;

use Awcodes\Recently\Livewire\RecentlyMenu;
use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;

class RecentlyPlugin implements Plugin
{
    use EvaluatesClosures;

    protected string | Closure | null $renderUsingHook = null;

    protected bool | Closure | null $rounded = null;

    protected string | Closure | null $label = null;

    protected string | Closure | null $icon = null;

    protected int | Closure | null $maxItems = null;

    public function getId(): string
    {
        return 'recently';
    }

    public function register(Panel $panel): void
    {
        Livewire::component('recently', RecentlyMenu::class);

        $panel
            ->renderHook(
                name: $this->getRenderHook(),
                hook: fn () => Blade::render('<livewire:recently />')
            );
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

    public function maxItems(int | Closure $maxItems): static
    {
        $this->maxItems = $maxItems;

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
        return $this->evaluate($this->icon) ?? 'heroicon-o-arrow-uturn-left';
    }

    public function getLabel(): ?string
    {
        return $this->evaluate($this->label) ?? null;
    }

    public function getMaxItems(): int
    {
        return $this->evaluate($this->maxItems) ?? 20;
    }

    public function getRenderHook(): string
    {
        return $this->evaluate($this->renderUsingHook) ?? PanelsRenderHook::USER_MENU_BEFORE;
    }

    public function isRounded(): bool
    {
        return $this->evaluate($this->rounded) ?? true;
    }
}
