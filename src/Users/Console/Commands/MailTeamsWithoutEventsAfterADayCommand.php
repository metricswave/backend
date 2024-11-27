<?php

namespace MetricsWave\Users\Console\Commands;

use App\Models\User;
use Cache;
use Http;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use MetricsWave\Teams\Team;
use MetricsWave\Users\Mail\TeamsWithoutEventsMail;

class MailTeamsWithoutEventsAfterADayCommand extends Command
{
    protected $signature = 'app:teams:mail-without-events {email?} {--sub-days=1}';

    protected $description = 'Mail team owner without events after a day of creation.';

    const CACHE_KEY = 'team_';

    public function handle(): void
    {
        $teams = $this->getTeams((int) $this->option('sub-days'), $this->argument('email'));

        if ($teams === null) {
            return;
        }

        $emailsSent = 0;

        $this->withProgressBar($teams, function (Team $team) use (&$emailsSent) {
            if (Cache::has(self::CACHE_KEY.$team->id) && $this->argument('email', false) === false) {
                return;
            }

            Mail::queue(new TeamsWithoutEventsMail(
                $team->triggers()->first()?->uuid,
                $team->owner->name,
                $team->owner->email,
                $team->domain,
            ));

            if (config('app.env') === 'production') {
                Http::get(
                    'https://metricswave.com/webhooks/60bb9264-5e13-42a5-b563-b914b516fc74',
                    [
                        'type' => 'Team Without Events Mail',
                        'email' => $team->owner->email,
                    ]
                );
            }

            $emailsSent++;

            Cache::set(self::CACHE_KEY.$team->id, true, now()->addWeek());
        });

        $this->newLine(2);
        $this->info($emailsSent.' mails sent.');
    }

    private function getTeams(int $subDays = 1, string $testMail = null): ?Collection
    {
        if ($testMail !== null) {
            $user = User::query()->where('email', $testMail)->first();

            if ($user === null) {
                $this->error('User not found.');

                return null;
            }

            if ($user->ownedTeams()->count() === 0) {
                $this->error('User does not own any team.');

                return null;
            }

            return $user->ownedTeams()->get();
        }

        return Team::query()
            ->where('initiated', false)
            ->where('created_at', '<', now()->subDays($subDays))
            ->where('created_at', '>', now()->subDays($subDays + 1))
            ->get();
    }
}
