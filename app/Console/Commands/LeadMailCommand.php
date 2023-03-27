<?php

namespace App\Console\Commands;

use App\Models\Lead;
use App\Models\MailLog;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

trait LeadMailCommand
{
    private function getMailableLeads(?string $email, string $type): Collection|array|EloquentCollection
    {
        if ($email !== null) {
            $leads = Lead::where('email', $email)->get();
        } else {
            $leads = Lead::whereNull('paid_at')->get();
            $mailLogs = MailLog::where('type', $type)->get()->pluck('mail');

            $leads = $leads->filter(function (Lead $lead) use ($mailLogs) {
                return !$mailLogs->contains($lead->email);
            });
        }

        return $leads;
    }
}
