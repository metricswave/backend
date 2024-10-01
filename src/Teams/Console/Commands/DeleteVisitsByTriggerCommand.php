<?php

namespace MetricsWave\Teams\Console\Commands;

use App\Models\Trigger;
use Illuminate\Console\Command;

class DeleteVisitsByTriggerCommand extends Command
{
    protected $signature = 'trigger:delete-visits {triggerId : The trigger id or UUID.}';

    protected $description = 'Delete events by trigger id or UUID.';

    public function handle(): void
    {
        $triggerId = $this->argument('triggerId');
        $trigger = Trigger::find($triggerId) ?? Trigger::query()->where('uuid', $triggerId)->first();

        if ($trigger === null) {
            $this->error('Trigger not found.');

            return;
        }

        $this->info('Deleting all visits for trigger.');
        $this->newLine();

        $this->deleteTriggerVisits($trigger);
    }

    private function deleteTriggerVisits(Trigger $trigger): void
    {
        $trigger->visits(Trigger::UNIQUE_VISITS)->delete();
        $trigger->visits(Trigger::NEW_VISITS)->delete();
        $trigger->visits()->delete();

        $trigger->visits()->deleteParams($trigger->configuration['fields']['parameters']);
    }
}
