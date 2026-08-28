---
title: Usage
description: Register the Recently plugin and choose which resource pages are recorded.
---

# Usage

## Registering the plugin

Register the plugin on each panel that should have a recent history:

```php
use Awcodes\Recently\RecentlyPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            RecentlyPlugin::make(),
        ]);
}
```

On its own this adds the topbar menu and registers the history resource for global search. Nothing is recorded yet — that is opt-in per page, below.

## Choosing what gets tracked

Add the `HasRecentHistoryRecorder` trait to the `EditRecord` and `ViewRecord` pages of the resources you want in the history. Only pages carrying the trait are recorded.

Recent edits:

```php
use Awcodes\Recently\Concerns\HasRecentHistoryRecorder;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    use HasRecentHistoryRecorder;

    protected static string $resource = UserResource::class;
}
```

Recent views:

```php
use Awcodes\Recently\Concerns\HasRecentHistoryRecorder;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    use HasRecentHistoryRecorder;

    protected static string $resource = UserResource::class;
}
```

The entry's title comes from the page title. If the resource has no record title attribute set, the record's ID is appended so entries stay distinguishable, and the icon is taken from the resource's navigation icon.

Recording happens on a full page render, not on Livewire updates, so interacting with a form does not write repeatedly.

## Clearing history

The menu includes a "Clear History" action. It deletes the current user's entries only — every query the package makes is constrained to the authenticated user.

## Possible conflicts

When global search is enabled, Recently registers a `RecentEntryResource` on the panel so entries are searchable. Plugins that enumerate the panel's resources will pick it up, which is usually not what you want. Exclude it from them:

```php
use Awcodes\Recently\Resources\RecentEntryResource;

OverlookPlugin::make()
    ->excludes([
        RecentEntryResource::class,
    ]),
QuickCreatePlugin::make()
    ->excludes([
        RecentEntryResource::class,
    ]),
```

If you turn global search off, the resource is never registered and the exclusions are unnecessary — see [Configuration](configuration.md).
