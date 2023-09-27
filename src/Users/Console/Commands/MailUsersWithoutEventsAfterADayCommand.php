<?php

namespace MetricsWave\Users\Console\Commands;

use App\Models\MailLog;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use MetricsWave\Users\Mail\UsersWithoutEventsMail;
use MetricsWave\Users\User;

class MailUsersWithoutEventsAfterADayCommand extends Command
{
    private const MAIL_TYPE = 'users_without_events';

    protected $signature = 'app:users:mail-without-events {email?} {{--sub-days=1}}';

    protected $description = 'Mail users without events after a day of registration';

    public function handle(): void
    {
        $users = $this->getUsers(
            (int) $this->option('sub-days'),
            $this->argument('email')
        );

        $this->withProgressBar($users, function (User $user) {
            Mail::send(new UsersWithoutEventsMail($user));
            MailLog::create(['mail' => $user->email, 'type' => self::MAIL_TYPE]);
        });

        $this->newLine(2);
        $this->info($users->count().' mails sent.');
    }

    private function getUsers(int $subDays = 1, string $testMail = null): Collection
    {
        if ($testMail !== null) {
            return collect(User::query()->where('email', $testMail)->get());
        }

        return User::query()
            ->whereNotIn('id', function ($query) {
                $query->select('secondary_key')
                    ->from('visits')
                    ->where('primary_key', 'like', 'visits:users_triggernotification_year');
            })
            ->whereDoesntHave('mailLogs', function ($query) {
                $query->where('type', self::MAIL_TYPE);
            })
            ->where('created_at', '>', Carbon::createFromFormat('Y-m-d H:i:s', '2023-06-15 00:00:00'))
            ->where('created_at', '<', now()->subDays($subDays))
            ->get();
    }
}
