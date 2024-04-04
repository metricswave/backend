<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use Illuminate\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use MetricsWave\Metrics\Models\Visit;
use MetricsWave\Teams\Team;

use function Pest\Laravel\getJson;

$csv = file_get_contents(__DIR__.'/assets/visits_parameters.csv');

$visits = fn (): array => collect(explode("\n", $csv))
    ->map(function ($row) {
        return explode(',', $row);
    })
    ->toArray();

it('return expected parameters stats when trigger has no params', function () {
    $dashboard = dashboard(['public' => true]);
    $trigger = Trigger::factory()
        ->for(Team::factory()->create())
        ->for(TriggerType::factory()->create())
        ->create(['id' => 48, 'uuid' => $dashboard->items->first()->eventUuid]);

    getJson('/api/dashboards/'.$dashboard->uuid.'/triggers/'.$trigger->uuid.'/parameters-stats')
        ->assertJson([])
        ->assertSuccessful();
});

it('return expected parameters stats', function () use ($visits) {
    $dashboard = dashboard(['public' => true]);
    $trigger = Trigger::factory()
        ->for(Team::factory()->create())
        ->for(TriggerType::factory()->create())
        ->create([
            'id' => 48,
            'uuid' => $dashboard->items->first()->eventUuid,
            'configuration' => [
                'fields' => ['parameters' => ['path', 'referrer']],
            ],
        ]);

    foreach ($visits() as $row) {
        if (count($row) === 1) {
            continue;
        }

        $expiredAt = $row[5] === '' ? null : new Carbon($row[5]);

        DB::table(Visit::tableNameForYear(($expiredAt ?? now())->year))
            ->insert([
                'primary_key' => Str::of($row[1])->replace('visits:triggers', 'visits:testing:triggers')->toString(),
                'secondary_key' => $row[2],
                'score' => (int) $row[3],
                'expired_at' => $expiredAt,
            ]);
    }

    getJson('/api/dashboards/'.$dashboard->uuid.'/triggers/'.$trigger->uuid.'/parameters-stats?date=2023-06-08')
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data.path')
            ->count('data.path', 7)
        )
        ->assertSuccessful();
});
