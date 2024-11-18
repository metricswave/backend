<?php

namespace MetricsWave\Teams\Console\Commands;

use App\Models\Trigger;
use Illuminate\Console\Command;
use MetricsWave\Teams\Team;

class DeleteVisitsByTeamIdCommand extends Command
{
    protected $signature = 'teams:delete-visits {teamId}
                            { --just-params : Only delete parameters rows }';

    protected $description = 'Delete events by team id.';

    public function handle(): void
    {
        $teamId = $this->argument('teamId');
        $team = Team::find($teamId);

        if ($team === null) {
            $this->error("Team with id {$teamId} not found.");

            return;
        }

        $this->info('Deleting all events for team '.$team->domain);
        $this->newLine();

        $this->withProgressBar(
            $team->triggers,
            fn (Trigger $trigger) => $this->deleteTriggerVisits($trigger),
        );
    }

    private function deleteTriggerVisits(Trigger $trigger): void
    {
        if ($this->option('just-params') === false) {
            $trigger->visits(Trigger::UNIQUE_VISITS)->delete();
            $trigger->visits(Trigger::NEW_VISITS)->delete();
            $trigger->visits()->delete();
        }

        $trigger->visits()->deleteParams($trigger->configurationParameters());
    }
}
