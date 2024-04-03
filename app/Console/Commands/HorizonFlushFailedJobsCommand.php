<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class HorizonFlushFailedJobsCommand extends Command
{
    protected $signature = 'horizon:flush';

    protected $description = 'Flush failed jobs via horizon';

    public function handle(): void
    {
        $this->call('queue:flush');
        Redis::connection(name: 'horizon')->client()->flushAll();
    }
}
