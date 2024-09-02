<?php

use Awcodes\Recently\Livewire\RecentlyMenu;
use Awcodes\Recently\RecentlyPlugin;
use Awcodes\Recently\Resources\RecentEntryResource;
use Awcodes\Recently\Tests\Models\User;
use Filament\Facades\Filament;

it('registers plugin', function () {
    $panel = Filament::getCurrentPanel();

    $panel->plugins([
        RecentlyPlugin::make(),
    ]);

    expect($panel->getPlugin('awcodes/recently'))
        ->not()
        ->toThrow(Exception::class);
});

it('can modify rounding', function ($condition) {
    $plugin = RecentlyPlugin::make()
        ->rounded($condition);

    expect($plugin)->isRounded()->toBe($condition);
})->with([
    false,
    fn () => true,
]);

it('can modify label', function ($label) {
    $plugin = RecentlyPlugin::make()
        ->label($label);

    expect($plugin)->getLabel()->toBe($label);
})->with([
    'test label',
    fn () => 'test function label',
]);

it('can modify icon', function ($icon) {
    $plugin = RecentlyPlugin::make()
        ->icon($icon);

    expect($plugin)->getIcon()->toBe($icon);
})->with([
    'heroicon-o-plus',
    fn () => 'heroicon-o-minus',
]);

it('can modify width', function ($width) {
    $plugin = RecentlyPlugin::make()
        ->width($width);

    expect($plugin)->getWidth()->toBe($width);
})->with([
    'sm',
    fn () => 'xl',
]);

it('can modify max items', function ($items) {
    $plugin = RecentlyPlugin::make()
        ->maxItems($items);

    expect($plugin)->getMaxItems()->toBe($items);
})->with([
    25,
    fn () => 50,
]);

it('can has global search', function () {
    $panel = Filament::getCurrentPanel();

    $panel->plugins([
        RecentlyPlugin::make(),
    ]);

    $plugin = $panel->getPlugin('awcodes/recently');

    expect($plugin)->hasGlobalSearch()->toBeTrue();

    $this->assertContains(RecentEntryResource::class, $panel->getResources());
});

it('can disable global search', function ($condition) {
    $panel = Filament::getCurrentPanel();

    $panel->plugins([
        RecentlyPlugin::make()
            ->globalSearch($condition),
    ]);

    $plugin = $panel->getPlugin('awcodes/recently');

    expect($plugin)->hasGlobalSearch()->toBe($condition);

    $this->assertNotContains(RecentEntryResource::class, $panel->getResources());
})->with([
    false,
    fn () => false,
]);

it('has menu', function () {
    $this->actingAs(User::factory()->create());

    $panel = Filament::getCurrentPanel();

    $panel->plugins([
        RecentlyPlugin::make(),
    ]);

    $plugin = $panel->getPlugin('awcodes/recently');

    expect($plugin)->hasMenu()->toBeTrue();

    $this
        ->get('/admin')
        ->assertSeeLivewire(RecentlyMenu::class);
});

it('has hides menu', function ($condition) {
    $this->actingAs(User::factory()->create());

    $panel = Filament::getCurrentPanel();

    $panel->plugins([
        RecentlyPlugin::make()
            ->menu($condition),
    ]);

    $plugin = $panel->getPlugin('awcodes/recently');

    expect($plugin)->hasMenu()->toBe($condition);

    $this
        ->get('/admin')
        ->assertDontSeeLivewire(RecentlyMenu::class);
})->with([
    false,
    fn () => false,
]);
