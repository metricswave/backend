<?php

namespace App\Console\Commands;

use App\Mail\LifetimeLicenseDealMail;
use App\Models\Lead;
use App\Models\MailLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class UserLifetimeLicenceMailCommand extends Command
{
    private const MAIL_TYPE = 'user-lifetime-license-v2';

    protected $signature = 'app:mail:user-lifetime-licence-mail {email?}';

    protected $description = 'Send lifetime license deal to user who has not bought a license yet.';

    public function handle(): void
    {
        if ($email = $this->argument('email')) {
            $leads = Lead::where('email', $email)->get();
        } else {
            $leads = Lead::whereNull('paid_at')->get();
            $mailLogs = MailLog::where('type', self::MAIL_TYPE)->get()->pluck('mail');

            $leads = $leads->filter(function (Lead $lead) use ($mailLogs) {
                return !$mailLogs->contains($lead->email);
            });
        }

        $this->withProgressBar($leads, function (Lead $lead) {
            Mail::send(new LifetimeLicenseDealMail($lead));

            MailLog::create([
                'mail' => $lead->email,
                'type' => self::MAIL_TYPE,
            ]);
        });
    }
}
