<?php

declare(strict_types=1);

use Awcodes\Recently\Livewire\RecentlyMenu;
use Awcodes\Recently\Models\RecentEntry;
use Awcodes\Recently\RecentlyPlugin;
use Awcodes\Recently\Tests\Models\User;
use Filament\Facades\Filament;

use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->user = $this->actingAs(User::factory()->create());

    $this->panel = Filament::getCurrentOrDefaultPanel();

    $this->panel->plugins([
        RecentlyPlugin::make()
            ->label('Recently Menu')
            ->icon('heroicon-o-plus')
            ->width('md')
            ->maxItems(10),
    ]);

    $this->plugin = Filament::getPlugin('awcodes/recently');
});

it('has correct properties', function () {
    livewire(RecentlyMenu::class)
        ->assertSet('label', 'Recently Menu')
        ->assertSet('icon', 'heroicon-o-plus')
        ->assertSet('width', 'md');
});

it('has correct items', function () {
    RecentEntry::factory()->count(25)->create();

    $data = RecentEntry::query()
        ->orderByDesc('updated_at')
        ->limit($this->plugin->getMaxItems())
        ->get();

    livewire(RecentlyMenu::class)
        ->assertCount('records', $this->plugin->getMaxItems())
        ->assertSet('records', $data);
});
