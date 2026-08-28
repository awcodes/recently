---
title: Configuration
description: Set Recently's options globally in the config file or per panel on the plugin.
---

# Configuration

Every feature can be set globally in the published config file, or overridden per panel on the plugin. A value set on the plugin wins; where none is set, the config value is used.

```php
// config/recently.php
return [
    'model' => Awcodes\Recently\Models\RecentEntry::class,
    'user_model' => App\Models\User::class,
    'max_items' => 20,
    'width' => 'xs',
    'global_search' => true,
    'menu' => true,
    'icon' => 'heroicon-o-arrow-uturn-left',
];
```

| Key | Purpose |
|---|---|
| `model` | The Eloquent model used to store entries. Swap it to extend the default. |
| `user_model` | The model entries belong to. Used by the migration's foreign key and the `user` relationship. |
| `max_items` | How many entries the menu lists. |
| `width` | Width of the dropdown. |
| `global_search` | Whether entries are searchable through global search. |
| `menu` | Whether the topbar menu renders at all. |
| `icon` | Icon for the menu trigger. |

> [!NOTE]
> `max_items` limits how many entries are *displayed*. It does not prune what is stored, so the `recent_entries` table keeps growing as users browse.

## Global search

By default entries are listed in the panel's global search results. To turn that off, set `global_search` to `false` in the config, or pass `false` per panel:

```php
use Awcodes\Recently\RecentlyPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            RecentlyPlugin::make()
                ->globalSearch(condition: false),
        ]);
}
```

This also controls whether `RecentEntryResource` is registered on the panel at all, which is what the conflicts in [Usage](usage.md) are about.

## Menu

By default the plugin renders a dropdown in the topbar. To turn it off — leaving only global search — set `menu` to `false` in the config, or pass `false` per panel:

```php
use Awcodes\Recently\RecentlyPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            RecentlyPlugin::make()
                ->menu(condition: false),
        ]);
}
```

## Max items

Set how many entries the menu lists, overriding `max_items` for this panel:

```php
use Awcodes\Recently\RecentlyPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            RecentlyPlugin::make()
                ->maxItems(10),
        ]);
}
```

Entries are ordered by when they were last visited, newest first.
