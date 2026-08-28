---
title: Appearance
description: Customise the Recently menu's icon, label, tooltip, width and placement.
---

# Appearance

All of these are set on the plugin, per panel. Each accepts a closure as well as a plain value.

## Icon

Set the icon used for the menu trigger, overriding the `icon` config value:

```php
use Awcodes\Recently\RecentlyPlugin;

RecentlyPlugin::make()
    ->icon('heroicon-o-clock'),
```

## Rounded

The trigger is a circle by default. Pass `false` for a rounded rectangle instead:

```php
use Awcodes\Recently\RecentlyPlugin;

RecentlyPlugin::make()
    ->rounded(condition: false),
```

## Label

The trigger shows only its icon by default. Setting a label puts text beside the icon and widens the trigger to fit:

```php
use Awcodes\Recently\RecentlyPlugin;

RecentlyPlugin::make()
    ->label('Recently Viewed Records'),
```

## Tooltip

Add a tooltip shown on hover. This is independent of the label — you can set either, both or neither:

```php
use Awcodes\Recently\RecentlyPlugin;

RecentlyPlugin::make()
    ->tooltip('Records you opened recently'),
```

## Width

The dropdown uses Filament's dropdown component, so it takes anything that component accepts — a `Width` enum case or its string equivalent. The default is `xs`.

```php
use Awcodes\Recently\RecentlyPlugin;
use Filament\Support\Enums\Width;

RecentlyPlugin::make()
    ->width(Width::Small),
```

## Render hook

The menu renders through `PanelsRenderHook::USER_MENU_BEFORE`. To place it elsewhere, pass a different panel render hook:

```php
use Awcodes\Recently\RecentlyPlugin;
use Filament\View\PanelsRenderHook;

RecentlyPlugin::make()
    ->renderUsingHook(PanelsRenderHook::USER_MENU_AFTER),
```

> [!WARNING]
> Pass the constant itself, not its name as a string. `renderUsingHook('PanelsRenderHook::USER_MENU_AFTER')` registers a hook that never fires, and the menu silently disappears.
