<?php

namespace MetricsWave\Users\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use MetricsWave\Teams\Team;
use MetricsWave\Users\Mail\TeamsWithoutEventsMail;

class MailTeamsWithoutEventsAfterADayCommand extends Command
{
    private const MAIL_TYPE = 'team_without_events';

    protected $signature = 'app:teams:mail-without-events {email?} {--sub-days=1}';

    protected $description = 'Mail team owner without events after a day of creation.';

    public function handle(): void
    {
        $teams = $this->getTeams((int) $this->option('sub-days'), $this->argument('email'));

        $this->withProgressBar($teams, function (Team $team) {
            if ($team->triggers()->first() === null) {
                return;
            }

            Mail::send(new TeamsWithoutEventsMail(
                $team->triggers()->first()->uuid,
                $team->owner->name,
                $team->owner->email,
                $team->domain,
            ));
        });

        $this->newLine(2);
        $this->info($teams->count().' mails sent.');
    }

    private function getTeams(int $subDays = 1, string $testMail = null): Collection
    {
        if ($testMail !== null) {
            /** @var User $owner */
            $owner = User::query()->where('email', $testMail)->get();
            return $owner->teams;
        }

        return Team::query()
            ->whereNotIn('id', function ($query) {
                $query->select('secondary_key')
                    ->from('visits')
                    ->where('primary_key', 'like', 'visits:teams_triggernotification_year');
            })
            ->where('created_at', '>', Carbon::createFromFormat('Y-m-d H:i:s', '2023-06-15 00:00:00'))
            ->where('created_at', '<', now()->subDays($subDays))
            ->get();
    }
}
