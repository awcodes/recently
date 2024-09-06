# Recently

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awcodes/recently.svg?style=flat-square)](https://packagist.org/packages/awcodes/recently)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/awcodes/recently/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/awcodes/recently/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/awcodes/recently/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/awcodes/recently/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/awcodes/recently.svg?style=flat-square)](https://packagist.org/packages/awcodes/recently)

<img src="https://res.cloudinary.com/aw-codes/image/upload/v1725456482/plugins/recently/awcodes-recently.jpg" alt="screenshots of palette in a filament panel" width="1200" height="auto" class="filament-hidden" style="width: 100%;" />

Easily track and access recently viewed records in your filament panels.

## Installation

You can install the package via composer then run the installation command and follow the prompts:

```bash
composer require awcodes/recently
```

```bash
php artisan recently:install
``` 
In an effort to align with Filament's theming methodology you will need to use a custom theme to use this plugin.

> [!IMPORTANT]
> If you have not set up a custom theme and are using a Panel follow the instructions in the [Filament Docs](https://filamentphp.com/docs/3.x/panels/themes#creating-a-custom-theme) first. The following applies to both the Panels Package and the standalone Forms package.

Add the plugin's views to your `tailwind.config.js` file.

```js
content: [
    './vendor/awcodes/recently/resources/**/*.blade.php',
]
```

## Usage
The plugin adds a “Recently Viewed” functionality in your filament panel(s), letting users quickly access resources they’ve recently interacted with. It tracks views/visits to `EditRecord` and `ViewRecord` pages of resources where it’s enabled.

### Registering the plugin

```php
use Awcodes\Recently\RecentlyPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            RecentlyPlugin::make(),
        ])
}
```

### Possible Conflicts

If you are using `QuickCreatePlugin` or `OverlookPlugin` you will need to exclude the `RecentEntryResource` from them.

```php
OverlookPlugin::make()
    ->excludes([
        RecentEntryResource::class,
    ]),
QuickCreatePlugin::make()
    ->excludes([
        RecentEntryResource::class,
    ]),
```

### Tracking Recent
To record recent edits/views, include the trait on `EditRecord` or `ViewRecord` pages of the resources you want to monitor:

**Recent Edits**:
```php
use Awcodes\Recently\Concerns\HasRecentHistoryRecorder;

class EditUser extends EditRecord
{
    use HasRecentHistoryRecorder;

    protected static string $resource = UserResource::class;
}
```
**Recent Views**:
```php
class ViewUser extends ViewRecord
{
    use HasRecentHistoryRecorder;

    protected static string $resource = UserResource::class;
}
```

## Configuration
You can enable/disable or customize the plugin's features either globally through the `config` file or per panel.

```php
// config/recently.php
return [
    'user_model' => App\Models\User::class,
    'max_items' => 20,
    'width' => 'xs',
    'global_search' => true,
    'menu' => true,
    'icon' => 'heroicon-o-arrow-uturn-left',
];
```

### Global Search
By default, the plugin will list the recent visits/views as part of the global search results. To disable this feature, set the `global_search` option to `false` from the config or by passing `false` to the `globalSearch()` method per panel.

```php
use Awcodes\Recently\RecentlyPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            RecentlyPlugin::make()
                ->globalSearch(condition: false),
        ])
}
```

### Menu
By default, the plugin will list the recent visits/views as a dropdown menu in the topbar using the `PanelsRenderHook::USER_MENU_BEFORE` render hook. To disable this feature, set the `menu` option to `false` in the config or by passing `false` to the `menu()` method per panel.

```php
use Awcodes\Recently\RecentlyPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            RecentlyPlugin::make()
                ->menu(condition: false),
        ])
}
```

## Appearance

### Icon
Set a custom `icon` for the **menu**.
```php
use Awcodes\Recently\RecentlyPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            RecentlyPlugin::make()
                ->icon('heroicon-o-clock'),
        ]);
}
```

### Rounded
The menu icon is round you can opt out of this by passing `false` to the `rounded()` method.
```php
use Awcodes\Recently\RecentlyPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            RecentlyPlugin::make()
                ->rounded(condition: false),
        ]);
}
```

### Label
The menu has no label, but you can set a custom `label` by passing a string to the `label()` method.
```php
use Awcodes\Recently\RecentlyPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            RecentlyPlugin::make()
                ->label('Recently Viewed Records'),
        ]);
}
```

### Width
The dropdown menu uses the filament [dropdown blade component](https://filamentphp.com/docs/3.x/support/blade-components/dropdown#setting-the-width-of-a-dropdown), so you can use any of the options available, the default is `xs`.

```php
use Awcodes\Recently\RecentlyPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            RecentlyPlugin::make()
                ->width('sm'),
        ]);
}
```

### Max Items
Specify the maximum number of recently viewed items to display in the **menu**.

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

### Render Hook
The plugin will render the menu using the `PanelsRenderHook::USER_MENU_BEFORE` hook. However, you can change this using the `renderUsingHook()` method by providing one of the other available filament [Render Hooks](https://filamentphp.com/docs/3.x/support/render-hooks).

```php
use Awcodes\Recently\RecentlyPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            RecentlyPlugin::make()
                ->renderUsingHook('PanelsRenderHook::USER_MENU_AFTER'),
        ]);
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

If you want to contribute to this plugin, you may want to test it in a real Filament project:

-   Fork this repository to your GitHub account.
-   Create a Filament app locally.
-   Clone your fork in your Filament app's root directory.
-   In the `/recently` directory, create a branch for your fix, e.g. `fix/error-message`.

Install the plugin in your app's `composer.json`:

```json
"require": {
    "awcodes/recently": "dev-fix/error-message as main-dev",
},
"repositories": [
    {
        "type": "path",
        "url": "recently"
    }
]
```

Now, run `composer update`.

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Adam Weston](https://github.com/awcodes)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
