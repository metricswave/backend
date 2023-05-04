<?php

namespace App\Services\Visits;

use Awssat\Visits\Visits as AwssatVisits;

class Visits extends AwssatVisits
{
    public function increment($inc = 1, $force = true, $ignore = []): bool
    {
        $response = parent::increment($inc, $force, $ignore);
        $this->periodsSync();

        return $response;
    }
}
