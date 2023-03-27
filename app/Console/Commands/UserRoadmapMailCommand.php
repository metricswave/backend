<?php

namespace App\Console\Commands;

use App\Mail\RoadmapMail;
use App\Models\Lead;
use App\Models\MailLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class UserRoadmapMailCommand extends Command
{
    use LeadMailCommand;

    private const MAIL_TYPE = 'user-roadmap';

    protected $signature = 'app:mail:user-roadmap {email?}';

    protected $description = 'Send a mail about the roadmap to the user.';

    public function handle(): void
    {
        $leads = $this->getMailableLeads($this->argument('email'), self::MAIL_TYPE);

        $this->withProgressBar($leads, function (Lead $lead) {
            Mail::send(new RoadmapMail($lead));

            MailLog::create([
                'mail' => $lead->email,
                'type' => self::MAIL_TYPE,
            ]);
        });
    }
}
