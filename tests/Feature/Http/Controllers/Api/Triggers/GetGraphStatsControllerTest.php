<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use Illuminate\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use MetricsWave\Metrics\Models\Visit;

use function Pest\Laravel\actingAs;

$csv = file_get_contents(__DIR__.'/assets/visits.csv');

$visits = fn (): array => collect(explode("\n", $csv))
    ->map(function ($row) {
        return explode(',', $row);
    })
    ->toArray();

$loadVisits = function (Trigger $trigger) use ($visits): void {
    foreach ($visits() as $row) {
        if (count($row) === 1) {
            continue;
        }

        $expiredAt = $row[5] === '' ? null : new Carbon($row[5]);

        $tableName = Visit::tableNameForYear(($expiredAt ?? now())->year);

        DB::table($tableName)->insert([
            'primary_key' => 'visits:testing:triggers_visits_day',
            'secondary_key' => $trigger->id,
            'score' => (int) $row[3],
            'expired_at' => $expiredAt,
        ]);
    }
};

it('return expected data', function () use ($loadVisits) {
    Date::setTestNow('2023-06-05');

    [$user, $team] = user_with_team();
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create([
            'configuration' => [
                'version' => '1.0',
                'type' => 'visits',
                'fields' => [
                    'parameters' => Trigger::VISITS_PARAMS,
                ],
            ],
        ]);

    $loadVisits($trigger);

    actingAs($user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/graph-stats')
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('data.period.date', '2023-06-06T00:00:00+00:00')
            ->where('data.period.period', '30d')
            ->where('data.headers.pageViews', 99)
            ->count('data.plot', 30)
            ->where('data.plot.0.date', '2023-05-07T00:00:00+00:00')
            ->where('data.plot.0.score', 3)
        );
});

it('return expected data with headers for money_income type', function () use ($loadVisits) {
    Date::setTestNow('2023-06-05');

    [$user, $team] = user_with_team();
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create([
            'configuration' => [
                'version' => '1.0',
                'type' => 'money_income',
                'fields' => [
                    'parameters' => ['amount', 'source'],
                ],
            ],
        ]);

    $loadVisits($trigger);

    actingAs($user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/graph-stats')
        ->assertSuccessful()
        ->dump()
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('data.period.date', '2023-06-06T00:00:00+00:00')
            ->where('data.period.period', '30d')
            ->where('data.headers.total_income', 99)
            ->count('data.plot', 30)
            ->where('data.plot.0.date', '2023-05-07T00:00:00+00:00')
            ->where('data.plot.0.score', 3)
        );
});

it('return expected data for week period', function () use ($loadVisits) {
    Date::setTestNow('2023-06-05');

    [$user, $team] = user_with_team();
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create();

    $loadVisits($trigger);

    actingAs($user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/graph-stats?period=7d')
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('data.period.date', '2023-06-06T00:00:00+00:00')
            ->where('data.period.period', '7d')
            ->where('data.headers', null)
            ->count('data.plot', 7)
            ->where('data.plot.0.date', '2023-05-30T00:00:00+00:00')
            ->where('data.plot.0.score', 6)
        );
});

it('return expected data for year period', function () use ($loadVisits) {
    Date::setTestNow('2023-06-05');

    [$user, $team] = user_with_team();
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create();

    $loadVisits($trigger);

    actingAs($user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/graph-stats?period=12m')
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('data.period.date', '2023-07-01T00:00:00+00:00')
            ->where('data.period.period', '12m')
            ->count('data.plot', 12)
        );
});

it('return expected data for custom daily period', function () use ($loadVisits) {
    Date::setTestNow('2023-09-05');

    [$user, $team] = user_with_team();
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create();

    $loadVisits($trigger);

    actingAs($user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/graph-stats?period=c_daily&date=2023-06-05&from-date=2023-05-05')
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('data.period.date', '2023-06-06T00:00:00+00:00')
            ->where('data.period.fromDate', '2023-05-05T00:00:00+00:00')
            ->where('data.period.period', 'c_daily')
            ->count('data.plot', 32)
            ->where('data.plot.0.score', 6)
            ->where('data.plot.1.score', 9)
        );
});
