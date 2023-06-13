<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class SendMetricsEventOnUserCreated
{
    public function handle(UserCreated $event): void
    {
        if (!app()->environment('production')) {
            return;
        }

        Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get(
            'https://metricswave.com/webhooks/c6f02d5f-9ece-469c-b4da-dbb2f7f548ea',
            [
                'count' => User::count(),
                'email' => $event->user->email,
            ],
        );
    }
}
