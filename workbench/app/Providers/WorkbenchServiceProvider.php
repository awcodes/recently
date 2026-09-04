<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Illuminate\Support\ServiceProvider;

class WorkbenchServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app['config']->set('recently.user_model', \Workbench\App\Models\User::class);

        $this->commands([
            \Workbench\App\Console\Commands\AssertRecentlyMigration::class,
            \Workbench\App\Console\Commands\InstallRecently::class,
        ]);
    }
}
