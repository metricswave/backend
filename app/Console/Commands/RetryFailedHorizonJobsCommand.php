<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Horizon\Contracts\JobRepository;
use Laravel\Horizon\Jobs\RetryFailedJob;

class RetryFailedHorizonJobsCommand extends Command
{
    protected $signature = 'horizon:retry-failed-jobs';

    protected $description = 'Retry failed jobs via horizon';

    public function __construct(private JobRepository $jobs)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $failedJobs = $this->jobs->getFailed();

        // You can create a progress bar:
        $bar = $this->output->createProgressBar($failedJobs->count());

        foreach ($failedJobs as $failedJob) {
            $uuid = $failedJob->uuid;
            $payload = json_decode($failedJob->payload);

            // Dispatch failed job via Horizon
            dispatch(new RetryFailedJob($uuid));

            // Delete it in database (if it fails again, it will create a new record)
            \DB::table('failed_jobs')->where('uuid', $uuid)->delete();

            $bar->advance();
        }

        $bar->finish();
    }
}
