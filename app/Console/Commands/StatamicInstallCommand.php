<?php

namespace App\Console\Commands;

use Statamic\Console\Commands\Install;

class StatamicInstallCommand extends Install
{
    protected $signature = 'statamic:install {--clear-cache : Clear the cache}';

    protected function clearCache(): StatamicInstallCommand|static
    {
        if ($this->option('clear-cache')) {
            $this->call('cache:clear');
        }

        return $this;
    }
}
