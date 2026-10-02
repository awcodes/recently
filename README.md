# Recently

Track recently viewed and edited records in your Filament panels and surface them in a topbar menu and global search.

[![Latest Version](https://img.shields.io/github/release/awcodes/recently.svg?style=flat-square&color=blue&label=Release)](https://github.com/awcodes/recently/releases)
[![MIT Licensed](https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/awcodes/recently.svg?style=flat-square&color=blue&label=Downloads)](https://packagist.org/packages/awcodes/recently)
[![GitHub Repo stars](https://img.shields.io/github/stars/awcodes/recently?style=flat-square&color=blue&label=Stars)](https://github.com/awcodes/recently/stargazers)
[![Filament Version](https://img.shields.io/badge/Filament-4.x%20%26%205.x-d97706.svg?style=flat-square)](https://filamentphp.com/docs/5.x/panels/installation)

## Documentation

The full documentation lives at **[docs.aw.codes/recently](https://docs.aw.codes/recently/3.x)**.

## Compatibility

| Filament version | Package version |
|------------------|-----------------|
| 3.x              | 1.x             |
| 5.x              | 2.x             |
| 4.x & 5.x        | 3.x             |

## Installation

```bash
composer require awcodes/recently
```

Then run `php artisan recently:install` to publish the config and migration, and add the package's views to your Tailwind theme — see [Installation](https://docs.aw.codes/recently/3.x/installation) for both steps.

## Changelog

Please see the [releases](https://github.com/awcodes/recently/releases) for what has changed recently.

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

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Adam Weston](https://github.com/awcodes)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
