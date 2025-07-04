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
        $afterIndex = 0;

        do {
            $failedJobs = $this->jobs->getFailed($afterIndex);

            foreach ($failedJobs as $failedJob) {
                $uuid = $failedJob->id;

                if (empty($failedJob->retried_by)) {
                    dispatch(new RetryFailedJob($uuid));
                    echo "R";
                }

                \DB::table('failed_jobs')->where('uuid', $uuid)->delete();
                $this->jobs->deleteFailed($uuid);

                echo "D";
            }

            $afterIndex += 50;
        } while ($failedJobs->count() > 0);
    }
}
