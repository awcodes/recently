<?php

declare(strict_types=1);

use Awcodes\Recently\Livewire\RecentlyMenu;
use Awcodes\Recently\Models\RecentEntry;
use Awcodes\Recently\RecentlyPlugin;
use Awcodes\Recently\Resources\RecentEntryResource;
use Filament\Facades\Filament;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Workbench\App\Filament\Resources\Pages\PageResource;
use Workbench\App\Models\Page;
use Workbench\App\Models\User;

use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);

    Filament::getCurrentOrDefaultPanel()->plugins([
        RecentlyPlugin::make(),
    ]);
});

function visitPage(Page $page): string
{
    $url = PageResource::getUrl('edit', ['record' => $page]);

    test()->get($url)->assertSuccessful();

    return $url;
}

function menuUrls(): array
{
    return livewire(RecentlyMenu::class)->instance()->records->pluck('url')->all();
}

function globalSearchUrls(): array
{
    return RecentEntryResource::getGlobalSearchEloquentQuery()->pluck('url')->all();
}

it('does not store a record reference when track_records is off', function () {
    $url = visitPage(Page::factory()->create());

    $this->assertDatabaseHas(RecentEntry::class, [
        'url' => $url,
        'recordable_type' => null,
        'recordable_id' => null,
    ]);
});

it('records history without the recordable columns when track_records is off', function () {
    Schema::table('recent_entries', function (Blueprint $table): void {
        $table->dropMorphs('recordable');
    });

    $url = visitPage(Page::factory()->create());

    expect(menuUrls())->toContain($url)
        ->and(globalSearchUrls())->toContain($url);
});

it('keeps showing entries for deleted records when track_records is off', function () {
    $page = Page::factory()->create();
    $url = visitPage($page);

    $page->delete();

    expect(menuUrls())->toContain($url)
        ->and(globalSearchUrls())->toContain($url);
});

describe('with track_records enabled', function () {
    beforeEach(function () {
        config()->set('recently.track_records', true);
    });

    it('stores a reference to the visited record', function () {
        $page = Page::factory()->create();
        $url = visitPage($page);

        $this->assertDatabaseHas(RecentEntry::class, [
            'url' => $url,
            'recordable_type' => $page->getMorphClass(),
            'recordable_id' => $page->getKey(),
        ]);
    });

    it('hides entries for soft deleted records', function () {
        $page = Page::factory()->create();
        $url = visitPage($page);

        expect(menuUrls())->toContain($url);

        $page->delete();

        expect(menuUrls())->not->toContain($url)
            ->and(globalSearchUrls())->not->toContain($url);
    });

    it('hides entries for force deleted records', function () {
        $page = Page::factory()->create();
        $url = visitPage($page);

        $page->forceDelete();

        expect(menuUrls())->not->toContain($url)
            ->and(globalSearchUrls())->not->toContain($url);
    });

    it('shows entries for soft deleted records when include_trashed_records is on', function () {
        config()->set('recently.include_trashed_records', true);

        $page = Page::factory()->create();
        $url = visitPage($page);

        $page->delete();

        expect(menuUrls())->toContain($url)
            ->and(globalSearchUrls())->toContain($url);

        $page->forceDelete();

        expect(menuUrls())->not->toContain($url);
    });

    it('keeps entries without a record reference', function () {
        RecentEntry::create([
            'user_id' => $this->user->id,
            'url' => 'https://example.test/legacy',
            'icon' => '',
            'title' => 'Legacy',
        ]);

        expect(menuUrls())->toContain('https://example.test/legacy')
            ->and(globalSearchUrls())->toContain('https://example.test/legacy');
    });

    it('hides entries whose record type no longer exists', function () {
        RecentEntry::create([
            'user_id' => $this->user->id,
            'url' => 'https://example.test/removed',
            'icon' => '',
            'title' => 'Removed',
            'recordable_type' => 'App\\Models\\RemovedModel',
            'recordable_id' => 1,
        ]);

        expect(menuUrls())->not->toContain('https://example.test/removed');
    });

    it('does not count entries for deleted records toward max_stored_items', function () {
        config()->set('recently.max_stored_items', 2);

        $deleted = Page::factory()->create();
        $deletedUrl = visitPage($deleted);
        $deleted->forceDelete();

        $first = visitPage(Page::factory()->create());
        $second = visitPage(Page::factory()->create());

        expect(RecentEntry::query()->pluck('url')->all())
            ->toHaveCount(2)
            ->toContain($first, $second)
            ->not->toContain($deletedUrl);
    });
});
