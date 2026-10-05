<?php

declare(strict_types=1);

use Awcodes\Focus\Card;
use Awcodes\Focus\Enums\Size;
use Awcodes\Focus\Screenshot;
use Awcodes\Focus\ScreenshotSuite;

/*
 * Documentation screenshots for Recently, generated with awcodes/focus from the Workbench (run `composer build`
 * first). The Workbench seeds the test user's history directly, with fixed timestamps, so the menu and global
 * search list the same entries in the same order on every build. The suite only opens the pages list, which is
 * not tracked, so a run never adds to that history.
 */

// The awcodes card templates frame each screenshot at 1400x816; the pages list is captured at 3/4 of that size
// so the menu stays legible once the template scales it up.
$card = [1050, 612];

return ScreenshotSuite::make()
    ->screenshots([
        // The open menu, framed with its trigger above it. The dropdown is teleported to the end of the page, so
        // the hook inside it identifies the panel.
        Screenshot::make('menu')
            ->visit('/admin/pages')
            ->click('button[aria-label="Recent Records"]')
            ->focus('[x-ref="panel"]:has([data-focus="recently-menu"])')
            ->padding(64),

        // Global search lists matching entries under the Recently group.
        Screenshot::make('global-search')
            ->viewportSize(1280, 720)
            ->visit('/admin/pages')
            ->fill('input[type="search"]', 'pr')
            ->waitFor('a:visible:has-text("Edit Privacy Policy")')
            ->viewport(),

        // The share-image source. The two-up templates show it dark in slot 1 and light in slot 2, so it is
        // captured in both themes. Slot 1 sits in front of the lower left of slot 2, clear of the menu at the
        // top right, so both slots use it.
        Screenshot::make('card-menu')
            ->viewportSize(...$card)
            ->visit('/admin/pages')
            ->click('button[aria-label="Recent Records"]')
            ->viewport(),
    ])
    ->cardTemplates('https://github.com/awcodes/focus-templates/tree/v2.1.0/dist')
    ->cards([
        // Open Graph and the GitHub social preview share one 2400x1260 template; GitHub crops 30px top and bottom.
        Card::make('social')
            ->template('two-up-wide')
            ->title('Recently')
            ->screenshots(['card-menu', 'card-menu'])
            ->sizes([Size::OpenGraph, Size::GitHubSocial]),

        // The Filament plugin directory's 2560x1440 thumbnail.
        Card::make('thumbnail')
            ->template('two-up')
            ->title('Recently')
            ->screenshots(['card-menu', 'card-menu'])
            ->sizes([Size::Filament]),

        // Unbranded 16:9 image for aw.codes, which adds its own heading: the same screenshots, no text or logo.
        Card::make('plain')
            ->template('two-up-plain')
            ->screenshots(['card-menu', 'card-menu'])
            ->sizes([[2560, 1440]])
            ->scale(1),
    ]);
