<?php

namespace App\Console\Commands;

use App\Models\Lead;
use App\Models\MailLog;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

trait LeadMailCommand
{
    private function getMailableLeads(?string $email, string $type, bool $avoidUsers = false): Collection|array|EloquentCollection
    {
        $leads = Lead::query()
            ->when($email !== null, fn ($query) => $query->where('email', $email))
            ->when($avoidUsers, fn ($query) => $query
                ->whereNotIn('email', fn ($query) => $query
                    ->select('email')->from('users')
                )
            )
            ->get();

        if ($email !== null) {
            return $leads;
        }

        $mailLogs = MailLog::query()->where('type', $type)->get()->pluck('mail');

        return $leads->filter(function (Lead $lead) use ($mailLogs) {
            return ! $mailLogs->contains($lead->email);
        });
    }

    private function getMailableLeadsWithoutLicences(?string $email, string $type): Collection|array|EloquentCollection
    {
        if ($email !== null) {
            $leads = Lead::where('email', $email)->get();
        } else {
            $leads = Lead::whereNull('paid_at')->orderBy('id')->get();
            $mailLogs = MailLog::where('type', $type)->get()->pluck('mail');

            $leads = $leads->filter(function (Lead $lead) use ($mailLogs) {
                return ! $mailLogs->contains($lead->email);
            });
        }

        return $leads;
    }

    private function getMailableLeadsWithLicences(?string $email, string $type): Collection|array|EloquentCollection
    {
        if ($email !== null) {
            $leads = Lead::where('email', $email)->get();
        } else {
            $leads = Lead::whereNotNull('paid_at')->orderBy('id')->get();
            $mailLogs = MailLog::where('type', $type)->get()->pluck('mail');

            $leads = $leads->filter(function (Lead $lead) use ($mailLogs) {
                return ! $mailLogs->contains($lead->email);
            });
        }

        return $leads;
    }
}
