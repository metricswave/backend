<?php

namespace App\Console\Commands;

use App\Models\MailLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

trait UserMailCommand
{
    private function getMailableUsers(?string $email, string $type): Collection|array|EloquentCollection
    {
        if ($email !== null) {
            $users = User::query()->where('email', $email)->get();
        } else {
            $users = User::query()
                ->where('marketing_mailable', true)
                ->get();
            $mailLogs = MailLog::query()
                ->where('type', $type)
                ->get()
                ->pluck('mail');

            $users = $users->filter(function (User $user) use ($mailLogs) {
                return ! $mailLogs->contains($user->email);
            });
        }

        return $users;
    }
}
