<?php

namespace MetricsWave\Metrics\Infrastructure;

use Illuminate\Database\Eloquent\Model;
use MetricsWave\Metrics\Metrics;
use MetricsWave\Metrics\MetricsInterface;

class MetricsBuilder
{
    public function __invoke(Model|string $subject, $tag = 'visits', bool $withCache = true): MetricsInterface
    {
        return new Metrics($subject, $tag, $withCache);
    }
}
