<?php

declare(strict_types=1);

namespace Workbench\App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class InstallRecently extends Command
{
    protected $signature = 'workbench:install-recently';

    protected $description = 'Materialize Recently through its documented installation command';

    public function handle(): int
    {
        $input = new ArrayInput([
            'command' => 'recently:install',
        ]);
        $input->setInteractive(false);

        $result = $this->getApplication()->find('recently:install')->run($input, new NullOutput);

        if ($result !== self::SUCCESS) {
            return $result;
        }

        $this->components->info('Recently installed; running migrations.');

        return $this->call('migrate', [
            '--force' => true,
        ]);
    }
}
