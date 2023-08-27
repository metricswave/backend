<?php

namespace MetricsWave\Metrics\Infrastructure;

use App\Models\Trigger;
use App\Models\User;
use App\Services\Visits\Visits;
use App\Services\Visits\VisitsInterface;
use Illuminate\Database\Eloquent\Model;
use MetricsWave\Metrics\Metrics;

class MetricsBuilder
{
    public function __invoke(Model|string $subject, $tag = 'visits'): VisitsInterface
    {
        if ($this->shouldUserMetricsWith($subject) && config('features.use_metrics')) {
            return new Metrics($subject, $tag);
        }

        return new Visits($subject, $tag);
    }

    private function shouldUserMetricsWith(string|Model $subject): bool
    {
        return (
            $subject instanceof Trigger && $subject->user->id === 1
        ) || (
            $subject instanceof User && $subject->id === 1
        );
    }
}
