<?php

declare(strict_types=1);

namespace Workbench\Database\Seeders;

use Awcodes\Recently\Models\RecentEntry;
use Carbon\CarbonImmutable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Workbench\App\Models\Page;
use Workbench\Database\Factories\UserFactory;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Pages and the test user's history are fixed, with fixed timestamps, so the Recently menu always lists the
     * same entries in the same order. Each entry matches what the recorder stores for a visit to the edit page.
     *
     * @var array<int, array{title: string, viewed_at: string|null}>
     */
    protected array $pages = [
        ['title' => 'Recently Viewed Page', 'viewed_at' => '2026-01-01 08:12:00'],
        ['title' => 'About Us', 'viewed_at' => '2026-01-01 08:54:00'],
        ['title' => 'Pricing', 'viewed_at' => '2026-01-01 08:41:00'],
        ['title' => 'Release Notes', 'viewed_at' => '2026-01-01 08:33:00'],
        ['title' => 'Contact', 'viewed_at' => '2026-01-01 08:27:00'],
        ['title' => 'Privacy Policy', 'viewed_at' => '2026-01-01 08:19:00'],
        ['title' => 'Careers', 'viewed_at' => null],
    ];

    public function run(): void
    {
        $user = UserFactory::new()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $created = CarbonImmutable::parse('2025-12-01 09:00:00');

        foreach ($this->pages as $index => ['title' => $title, 'viewed_at' => $viewedAt]) {
            $page = Page::query()->forceCreate([
                'title' => $title,
                'slug' => str($title)->slug()->toString(),
                'content' => $index === 0
                    ? 'Edit this page to add it to the Recently menu and global search.'
                    : "The {$title} page.",
                'created_at' => $created->addDays($index),
                'updated_at' => $created->addDays($index),
            ]);

            if ($viewedAt === null) {
                continue;
            }

            RecentEntry::query()->forceCreate([
                'user_id' => $user->getKey(),
                'url' => "/admin/pages/{$page->getKey()}/edit",
                'icon' => 'heroicon-o-document-text',
                'title' => "Edit {$title}",
                'created_at' => $viewedAt,
                'updated_at' => $viewedAt,
            ]);
        }
    }
}
