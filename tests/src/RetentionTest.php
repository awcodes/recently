<?php

declare(strict_types=1);

use Awcodes\Recently\Facades\Recently;
use Awcodes\Recently\Models\RecentEntry;
use Awcodes\Recently\RecentlyPlugin;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);

    Filament::getCurrentOrDefaultPanel()->plugins([
        RecentlyPlugin::make(),
    ]);
});

function storedEntriesFor(User $user)
{
    return RecentEntry::withoutGlobalScopes()->where('user_id', $user->id);
}

it('keeps every entry when max_stored_items is not set', function () {
    foreach (range(1, 25) as $i) {
        Recently::add("https://example.test/page/{$i}", '', "Page {$i}");
    }

    expect(storedEntriesFor($this->user)->count())->toBe(25);
});

it('prunes stored entries down to max_stored_items', function () {
    config()->set('recently.max_stored_items', 5);

    foreach (range(1, 8) as $i) {
        Recently::add("https://example.test/page/{$i}", '', "Page {$i}");
    }

    $urls = storedEntriesFor($this->user)->pluck('url');

    expect($urls)->toHaveCount(5)
        ->toContain('https://example.test/page/8')
        ->not->toContain('https://example.test/page/1');
});

it('only prunes the current user\'s entries', function () {
    config()->set('recently.max_stored_items', 2);

    $other = User::factory()->create();

    RecentEntry::create([
        'user_id' => $other->id,
        'url' => 'https://example.test/other',
        'icon' => '',
        'title' => 'Other',
    ]);

    foreach (range(1, 4) as $i) {
        Recently::add("https://example.test/page/{$i}", '', "Page {$i}");
    }

    expect(storedEntriesFor($this->user)->count())->toBe(2)
        ->and(storedEntriesFor($other)->count())->toBe(1);
});

it('prunes nothing with model:prune when prune_after_days is not set', function () {
    RecentEntry::factory()->create(['user_id' => $this->user->id, 'updated_at' => Carbon::now()->subYear()]);

    $this->artisan('model:prune', ['--model' => RecentEntry::class])->assertSuccessful();

    expect(storedEntriesFor($this->user)->count())->toBe(1);
});

it('prunes entries older than prune_after_days with model:prune', function () {
    config()->set('recently.prune_after_days', 30);

    RecentEntry::factory()->create(['user_id' => $this->user->id, 'url' => 'https://example.test/old', 'updated_at' => Carbon::now()->subDays(31)]);
    RecentEntry::factory()->create(['user_id' => $this->user->id, 'url' => 'https://example.test/new', 'updated_at' => Carbon::now()->subDays(29)]);

    $this->artisan('model:prune', ['--model' => RecentEntry::class])->assertSuccessful();

    expect(storedEntriesFor($this->user)->pluck('url')->all())->toBe(['https://example.test/new']);
});
