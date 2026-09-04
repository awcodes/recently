<?php

declare(strict_types=1);

namespace Workbench\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AssertRecentlyMigration extends Command
{
    protected $signature = 'workbench:assert-recently-migration';

    protected $description = 'Assert that exactly one Recently consumer migration is materialized';

    public function handle(): int
    {
        $migrations = File::glob(database_path('migrations/*_create_recently_table.php'));

        if (count($migrations) !== 1) {
            $this->components->error(sprintf(
                'Expected exactly one materialized Recently migration; found %d.',
                count($migrations),
            ));

            return self::FAILURE;
        }

        $this->components->info('Exactly one Recently consumer migration is materialized.');

        return self::SUCCESS;
    }
}
