<?php

namespace App\Console\Commands;

use App\Mail\LifetimeLicenseDealMail;
use App\Models\Lead;
use App\Models\MailLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class UserLifetimeLicenceMailCommand extends Command
{
    protected $signature = 'app:mail:user-lifetime-licence-mail';

    protected $description = 'Send lifetime license deal to user who has not bought a license yet.';

    public function handle(): void
    {
        $leads = Lead::whereNull('paid_at')->get();
        $mailLogs = MailLog::where('type', 'user-lifetime-license')->get()->pluck('mail');

        $leads = $leads->filter(function (Lead $lead) use ($mailLogs) {
            return !$mailLogs->contains($lead->email);
        });

        $this->withProgressBar($leads, function (Lead $lead) use ($mailLogs) {
            Mail::send(new LifetimeLicenseDealMail($lead));

            MailLog::create([
                'mail' => $lead->email,
                'type' => 'user-lifetime-license',
            ]);
        });
    }
}
