<?php

namespace App\Console\Commands;

use App\Mail\BetaAccessMail;
use App\Models\Lead;
use App\Models\MailLog;
use Illuminate\Console\Command;
use Mail;

class MailLeadForBetaAccessCommand extends Command
{
    use LeadMailCommand;

    private const MAIL_TYPE = 'user-beta-access-v1';

    protected $signature = 'app:mail:lead-beta-access {email?}';

    protected $description = 'Send beta access deal to user who already has a license.';

    public function handle(): int
    {
        $leads = $this->getMailableLeads($this->argument('email'), self::MAIL_TYPE)
            ->slice(0, 5);

        $this->withProgressBar($leads, function (Lead $lead) {
            Mail::send(new BetaAccessMail($lead));

            MailLog::create([
                'mail' => $lead->email,
                'type' => self::MAIL_TYPE,
            ]);
        });

        return self::SUCCESS;
    }
}
