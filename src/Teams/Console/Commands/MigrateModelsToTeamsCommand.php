<?php

namespace MetricsWave\Teams\Console\Commands;

use App\Models\Dashboard;
use App\Models\Trigger;
use Illuminate\Console\Command;
use MetricsWave\Users\User;

class MigrateModelsToTeamsCommand extends Command
{
    protected $signature = 'app:migrate:models-to-teams';

    protected $description = 'Migrate models to new teams parent.';

    public function handle(): void
    {
        $this->info('Migrating models to teams...');

        $this->createDefaultTeamForEachUserIfNeeded();
        $this->migrateTriggersToTeam();
        $this->migrateDashboardsToTeam();

        $this->info('All done!');
    }

    private function createDefaultTeamForEachUserIfNeeded(): void
    {
        $this->info('Creating default team for each user...');

        $this->withProgressBar(User::all(), function (User $user) {
            if ($user->ownedTeams()->count() === 0) {
                $user->ownedTeams()->create([
                    'domain' => 'Default',
                ]);
            }
        });

        $this->newLine(2);
    }

    private function migrateTriggersToTeam(): void
    {
        $this->info('Migrating triggers to teams...');

        $this->withProgressBar(User::all(), function (User $user) {
            Trigger::withTrashed()->where('user_id', $user->id)->update([
                'team_id' => $user->ownedTeams()->first()->id,
            ]);
        });

        $this->newLine(2);
    }

    private function migrateDashboardsToTeam(): void
    {
        $this->info('Migrating dashboards to teams...');

        $this->withProgressBar(User::all(), function (User $user) {
            Dashboard::query()->where('user_id', $user->id)->update([
                'team_id' => $user->ownedTeams()->first()->id,
            ]);
        });

        $this->newLine(2);
    }
}
