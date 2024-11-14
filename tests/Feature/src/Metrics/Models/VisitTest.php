<?php

use Carbon\Carbon;
use MetricsWave\Metrics\Models\Visit;

it('return expected array of tables', function (int $currentYear, array $result) {
    Carbon::setTestNow($currentYear.'-01-01 12:00:00');

    expect(Visit::tables())->toBe($result);
})->with([
    [2024, ['visits_old', 'visits_2024']],
    [2025, ['visits_old', 'visits_2024', 'visits_2025']],
    [2029, ['visits_old', 'visits_2024', 'visits_2025', 'visits_2026', 'visits_2027', 'visits_2028', 'visits_2029']],
]);
