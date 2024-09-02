<?php

use Awcodes\Recently\Livewire\RecentlyMenu;
use Awcodes\Recently\Models\RecentEntry;
use Awcodes\Recently\RecentlyPlugin;
use Awcodes\Recently\Tests\Models\Page;
use Awcodes\Recently\Tests\Models\User;
use Awcodes\Recently\Tests\Resources\PageResource;
use Filament\Facades\Filament;

use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->user = $this->actingAs(User::factory()->create());

    $this->panel = Filament::getCurrentPanel();

    $this->panel->plugins([
        RecentlyPlugin::make(),
    ]);

    $this->plugin = Filament::getPlugin('awcodes/recently');
});

it('has correct items', function () {
    $url = PageResource::getUrl('edit', ['record' => Page::factory()->create()]);

    $this->get($url)->assertSuccessful();

    $this->assertDatabaseHas(RecentEntry::class, [
        'url' => $url,
    ]);

    $data = RecentEntry::query()
        ->orderByDesc('updated_at')
        ->limit($this->plugin->getMaxItems())
        ->get();

    livewire(RecentlyMenu::class)
        ->assertSet('records', $data);
});
