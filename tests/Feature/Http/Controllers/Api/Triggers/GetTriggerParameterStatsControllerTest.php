<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use Illuminate\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;

use MetricsWave\Metrics\Models\Visit;

use function Pest\Laravel\actingAs;

$csv = file_get_contents(__DIR__.'/assets/visits_parameters.csv');

$visits = fn (): array => collect(explode("\n", $csv))
    ->map(function ($row) {
        return explode(',', $row);
    })
    ->toArray();

it('return expected parameters stats when trigger has no params', function () {
    [$user, $team] = user_with_team();
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create(['id' => 48]);

    actingAs($user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/parameters-stats')
        ->assertJson([])
        ->assertSuccessful();
});

it('return expected parameters stats', function () use ($visits) {
    [$user, $team] = user_with_team();
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create([
            'id' => 48,
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

    actingAs($user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/parameters-stats?date=2023-06-08')
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data.path')
            ->count('data.path', 7)
        )
        ->assertSuccessful();
});

it('return expected parameters stats without any date param', function () use ($visits) {
    [$user, $team] = user_with_team();
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create([
            'id' => 48,
            'configuration' => [
                'fields' => ['parameters' => ['path']],
            ],
        ]);

    Carbon::setTestNow('2023-06-08');

    foreach ($visits() as $row) {
        if (count($row) === 1) {
            continue;
        }

        DB::table(Visit::tableNameForYear(now()->year))
            ->insert([
                'primary_key' => Str::of($row[1])->replace('visits:triggers', 'visits:testing:triggers')->toString(),
                'secondary_key' => $row[2],
                'score' => (int) $row[3],
                'expired_at' => $row[5] === '' ? null : new Carbon($row[5]),
            ]);
    }

    actingAs($user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/parameters-stats')
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data.path')
            ->count('data.path', 7)
        )
        ->assertSuccessful();
});
