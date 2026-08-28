---
title: Installation
description: Install Recently, publish its config and migration, and register its styles with your Filament theme.
---

# Installation

## Requiring the package

Install the package via Composer:

```bash
composer require awcodes/recently
```

Then run the installer and follow the prompts:

```bash
php artisan recently:install
```

The installer publishes the config file, publishes the migration, offers to run it, and offers to star the repository on GitHub. The migration creates a `recent_entries` table holding the user reference, URL, icon, title and timestamps.

## Registering the styles

The menu renders from a Blade view inside the package, so Tailwind needs to scan it when building your CSS.

> [!IMPORTANT]
> If you have not set up a custom theme and are using Filament Panels, follow the instructions in the [Filament documentation](https://filamentphp.com/docs/4.x/styling/overview#creating-a-custom-theme) first.

Once you have a custom theme, add the package's views to your theme's CSS file — or your application's CSS file if you are using the standalone packages:

```css
@source '../../../../vendor/awcodes/recently/resources/**/*.blade.php';
```

Adjust the relative path if your CSS file does not live in the default theme location.

With the package installed, register the plugin on your panel — see [Usage](usage.md).
