<?php

namespace App\Services\Leads;

use App\Models\Lead;
use Illuminate\Support\Str;

class FirstOrCreateLeadService
{
    public function __invoke(string $mail): Lead
    {
        return Lead::firstOrCreate(
            ['email' => $mail],
            ['uuid' => Str::uuid()->toString()]
        );
    }
}
