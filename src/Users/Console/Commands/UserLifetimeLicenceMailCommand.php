<?php

namespace MetricsWave\Users\Console\Commands;

use App\Console\Commands\LeadMailCommand;
use App\Mail\LifetimeLicenseDealMail;
use App\Models\Lead;
use App\Models\MailLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class UserLifetimeLicenceMailCommand extends Command
{
    use LeadMailCommand;

    private const MAIL_TYPE = 'user-lifetime-license-v2';

    protected $signature = 'app:mail:user-lifetime-licence-mail {email?}';

    protected $description = 'Send lifetime license deal to user who has not bought a license yet.';

    public function handle(): void
    {
        $leads = $this->getMailableLeadsWithoutLicences($this->argument('email'), self::MAIL_TYPE);

        $this->withProgressBar($leads, function (Lead $lead) {
            Mail::send(new LifetimeLicenseDealMail($lead));

            MailLog::create([
                'mail' => $lead->email,
                'type' => self::MAIL_TYPE,
            ]);
        });
    }
}
