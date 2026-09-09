<?php

declare(strict_types=1);

use Awcodes\Recently\Facades\Recently;
use Awcodes\Recently\Models\RecentEntry;
use Awcodes\Recently\RecentlyPlugin;
use Awcodes\Recently\Tests\Models\User;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);

    $this->panel = Filament::getCurrentOrDefaultPanel();
    $this->panel->plugins([RecentlyPlugin::make()]);
});

it('keeps only the most recent max_items entries per user', function () {
    $max = config('recently.max_items');

    for ($i = 0; $i < $max + 5; $i++) {
        Recently::add("https://example.test/page/{$i}", '', "Page {$i}");
    }

    $stored = RecentEntry::withoutGlobalScopes()->where('user_id', $this->user->id);

    expect($stored->count())->toBe($max)
        // the most recently recorded url is kept; the oldest is dropped
        ->and((clone $stored)->where('url', 'https://example.test/page/'.($max + 4))->exists())->toBeTrue()
        ->and((clone $stored)->where('url', 'https://example.test/page/0')->exists())->toBeFalse();
});

it('prunes per user, leaving other users untouched', function () {
    $max = config('recently.max_items');

    $other = User::factory()->create();
    RecentEntry::create([
        'user_id' => $other->id,
        'url' => 'https://example.test/other',
        'icon' => '',
        'title' => 'Other',
    ]);

    for ($i = 0; $i < $max + 3; $i++) {
        Recently::add("https://example.test/page/{$i}", '', "Page {$i}");
    }

    expect(RecentEntry::withoutGlobalScopes()->where('user_id', $this->user->id)->count())->toBe($max)
        ->and(RecentEntry::withoutGlobalScopes()->where('user_id', $other->id)->count())->toBe(1);
});
