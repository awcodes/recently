---
title: Recently
description: Track recently viewed records in a Filament panel and surface them in a topbar menu and global search.
---

# Recently

Recently records the resource pages each user opens in a Filament panel and gives them a quick way back. It adds a dropdown to the topbar listing what that user viewed or edited most recently, and it can surface the same history through global search.

Tracking is opt-in per page: you add a trait to the `EditRecord` and `ViewRecord` pages you want recorded, so only the resources you choose end up in a user's history.

## How it works

Each time a tracked page is rendered, Recently stores the page's URL, the resource's navigation icon and the record's title against the current user. Entries are keyed on the user and the URL, so revisiting a record moves it back to the top of the list rather than creating a duplicate.

History is per user throughout — a global scope on the model constrains every query to the authenticated user, so one user never sees another's records.

## Compatibility

| Package version | Filament version |
|-----------------|------------------|
| 1.x             | 3.x              |
| 2.x             | 5.x              |
| 3.x             | 4.x & 5.x        |

Recently requires PHP 8.2 or later and `filament/filament` — it is a Panels plugin.

## Where to go next

- [Installation](installation.md) — install the package, run the installer, register the styles.
- [Usage](usage.md) — register the plugin and choose which pages are tracked.
- [Configuration](configuration.md) — the config file, global search and the menu.
- [Appearance](appearance.md) — icon, label, width and where the menu renders.
