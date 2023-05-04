<?php

namespace App\Console\Commands;

use App\Mail\UserWithoutTriggersMail;
use App\Models\MailLog;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Mail;

class MailUsersWithoutTriggersCommand extends Command
{
    private const MAIL_TYPE = 'user-without-triggers';

    protected $signature = 'app:mail-users-without-triggers-command {email?} {--days-ago=2}';

    protected $description = 'Mail users created three days ago that have no triggers yet.';

    public function handle(): int
    {
        $users = $this->getUsersWithoutTriggers($this->option('days-ago'), $this->argument('email'));

        $this->withProgressBar($users, function (User $user) {
            Mail::send(new UserWithoutTriggersMail($user));

            MailLog::create(['mail' => $user->email, 'type' => self::MAIL_TYPE]);
        });

        $this->newLine(2);
        $this->info($users->count().' mails sent.');

        return self::SUCCESS;
    }

    private function getUsersWithoutTriggers(
        int $createdDaysAgo,
        string $testMail = null
    ): Collection {
        if ($testMail !== null) {
            return collect(User::query()->where('email', $testMail)->get());
        }

        return User::query()
            ->whereDay('created_at', now()->subDays($createdDaysAgo)->day)
            ->whereDoesntHave('triggers')
            ->whereDoesntHave('mailLogs', function ($query) {
                $query->where('type', self::MAIL_TYPE);
            })
            ->get();
    }
}
