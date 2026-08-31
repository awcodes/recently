<?php

declare(strict_types=1);

use Awcodes\Recently\Livewire\RecentlyMenu;
use Awcodes\Recently\Models\RecentEntry;
use Awcodes\Recently\RecentlyPlugin;
use Awcodes\Recently\Resources\RecentEntryResource;
use Awcodes\Recently\Tests\Models\Page;
use Awcodes\Recently\Tests\Models\User;
use Awcodes\Recently\Tests\Resources\Pages\PageResource;
use Filament\Facades\Filament;

use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);

    $this->panel = Filament::getCurrentOrDefaultPanel();
    $this->panel->plugins([RecentlyPlugin::make()]);

    $this->plugin = Filament::getPlugin('awcodes/recently');
});

it('stores a polymorphic reference to the viewed record', function () {
    $page = Page::factory()->create();
    $url = PageResource::getUrl('edit', ['record' => $page]);

    $this->get($url)->assertSuccessful();

    $this->assertDatabaseHas(RecentEntry::class, [
        'url' => $url,
        'recordable_type' => $page->getMorphClass(),
        'recordable_id' => $page->getKey(),
    ]);
});

it('hides entries whose record has been deleted, keeping live and reference-less ones', function () {
    $page = Page::factory()->create();
    $url = PageResource::getUrl('edit', ['record' => $page]);
    $this->get($url)->assertSuccessful();

    // an entry that points at nothing (no record reference) must always survive
    RecentEntry::create([
        'user_id' => $this->user->id,
        'url' => 'https://example.test/legacy',
        'icon' => '',
        'title' => 'Legacy',
    ]);

    expect(RecentEntry::existing()->pluck('url')->all())->toContain($url);

    $page->delete();

    expect(RecentEntry::existing()->pluck('url')->all())
        ->not->toContain($url)
        ->toContain('https://example.test/legacy');

    // menu surface
    $records = livewire(RecentlyMenu::class)->instance()->records;
    expect($records->pluck('url')->all())->not->toContain($url);

    // global-search surface
    $searchUrls = RecentEntryResource::getGlobalSearchEloquentQuery()->pluck('url')->all();
    expect($searchUrls)->not->toContain($url);
});
