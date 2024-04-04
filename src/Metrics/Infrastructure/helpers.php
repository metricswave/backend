<?php

use MetricsWave\Metrics\Infrastructure\MetricsBuilder;
use MetricsWave\Metrics\MetricsInterface;

if (! function_exists('visitsService')) {
    function visitsService($subject, $tag = 'visits', bool $withCache = true): MetricsInterface
    {
        return (new MetricsBuilder())($subject, $tag, $withCache);
    }
}
