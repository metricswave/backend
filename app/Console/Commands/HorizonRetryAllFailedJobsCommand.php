<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Horizon\Contracts\JobRepository;
use Laravel\Horizon\Jobs\RetryFailedJob;

class HorizonRetryAllFailedJobsCommand extends Command
{
    protected $signature = 'app:horizon:retry-all-failed';

    protected $description = 'Retry and delete all failed jobs in horizon';

    public function __construct(private readonly JobRepository $jobs)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $failed = $this->jobs->getFailed();

        $this->info("Retrying {$failed->count()} jobs...");

        $this->withProgressBar($failed, function ($job) {
            dispatch(new RetryFailedJob($job->id));

            $this->jobs->deleteFailed($job->id);
        });

        return self::SUCCESS;
    }
}
