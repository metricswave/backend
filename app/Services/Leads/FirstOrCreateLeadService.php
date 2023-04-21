<?php

namespace App\Services\Leads;

use App\Models\Lead;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FirstOrCreateLeadService
{
    public function __invoke(string $mail): Lead
    {
        if (Lead::query()->where('email', $mail)->exists()) {
            return Lead::query()->where('email', $mail)->first();
        }

        $lead = Lead::create([
            'email' => $mail,
            'uuid' => Str::random(15),
        ]);

        $this->notify();

        return $lead;
    }

    private function notify(): void
    {
        Http::get(
            'https://notifywave.com/webhooks/29c31fab-a1c6-491d-92ff-081e69744651',
            [
                'count' => Lead::query()->count(),
            ]
        );
    }
}
