<?php

use App\Services\Visits\VisitsInterface;
use MetricsWave\Metrics\Infrastructure\MetricsBuilder;

if (! function_exists('visitsService')) {
    function visitsService($subject, $tag = 'visits'): VisitsInterface
    {
        return (new MetricsBuilder())($subject, $tag);
    }
}
