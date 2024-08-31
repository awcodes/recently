<?php

namespace Awcodes\Recently\Commands;

use Illuminate\Console\Command;

class RecentlyCommand extends Command
{
    public $signature = 'recently';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
