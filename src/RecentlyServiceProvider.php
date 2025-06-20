<?php

declare(strict_types=1);

namespace Awcodes\Recently;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RecentlyServiceProvider extends PackageServiceProvider
{
    public static string $name = 'recently';

    public static string $viewNamespace = 'recently';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasConfigFile()
            ->hasMigrations($this->getMigrations())
            ->hasTranslations()
            ->hasViews(static::$viewNamespace)
            ->hasInstallCommand(function (InstallCommand $command): void {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('awcodes/recently');
            });
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void {}

    protected function getAssetPackageName(): ?string
    {
        return 'awcodes/recently';
    }

    /** @return array<string> */
    protected function getMigrations(): array
    {
        return [
            'create_recently_table',
        ];
    }
}
