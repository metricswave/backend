<?php

namespace App\Console\Commands;

use App\Mail\BetaAccessMail;
use App\Models\Lead;
use App\Models\MailLog;
use Illuminate\Console\Command;
use Mail;
use MetricsWave\Users\User;

class MailLeadForBetaAccessCommand extends Command
{
    use LeadMailCommand;

    private const MAIL_TYPE = 'user-beta-access-v1';

    protected $signature = 'app:mail:lead-beta-access {--free-users} {--count=5} {email?}';

    protected $description = 'Send beta access deal to user who already has a license.';

    public function handle(): int
    {
        $count = $this->option('count');

        if ($this->option('free-users')) {
            $this->info('Sending to free users');
            $leads = $this->getMailableLeadsWithoutLicences($this->argument('email'), self::MAIL_TYPE)
                ->slice(0, $count);
        } else {
            $this->info('Sending to paid users');
            $leads = $this->getMailableLeadsWithLicences($this->argument('email'), self::MAIL_TYPE)
                ->slice(0, $count);
        }

        $this->withProgressBar($leads, function (Lead $lead) {
            if (User::query()->where('email', $lead->email)->exists()) {
                return;
            }

            Mail::send(new BetaAccessMail($lead));

            MailLog::create([
                'mail' => $lead->email,
                'type' => self::MAIL_TYPE,
            ]);
        });

        return self::SUCCESS;
    }
}
