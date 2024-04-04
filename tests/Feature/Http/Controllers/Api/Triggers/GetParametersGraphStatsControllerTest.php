<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use Illuminate\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;

use MetricsWave\Metrics\Models\Visit;

use function Pest\Laravel\actingAs;

$csv = file_get_contents(__DIR__.'/assets/visits_parameters.csv');
$visits = fn (): array => collect(explode("\n", $csv))->map(fn ($row) => explode(',', $row))->toArray();

it('return expected parameters stats when trigger has no params', function () {
    [$user, $team] = user_with_team();
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create(['id' => 48]);

    actingAs($user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/parameters-graph-stats')
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
        ->getJson('/api/triggers/'.$trigger->uuid.'/parameters-graph-stats?date=2023-06-08')
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('data.period.date', '2023-06-09T00:00:00+00:00')
            ->where('data.period.period', '30d')
            ->has('data.plot.path')
            ->count('data.plot.path', 7)
            ->where('data.plot.path.0.param', '/open')
            ->where('data.plot.path.0.score', 13)
            ->has('data.plot.referrer')
        )
        ->assertSuccessful();
});

it('return expected parameters stats with only one parameter', function () use ($visits) {
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

        DB::table(Visit::tableNameForYear(now()->year))
            ->insert([
                'primary_key' => Str::of($row[1])->replace('visits:triggers', 'visits:testing:triggers')->toString(),
                'secondary_key' => $row[2],
                'score' => (int) $row[3],
                'expired_at' => $row[5] === '' ? null : new Carbon($row[5]),
            ]);
    }

    actingAs($user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/parameters-graph-stats/referrer?date=2023-06-08')
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('data.period.date', '2023-06-09T00:00:00+00:00')
            ->where('data.period.period', '30d')
            ->has('data.plot.referrer')
            ->missing('data.plot.path')
        )
        ->assertSuccessful();
});

it('return expected parameters stats by week', function () use ($visits) {
    Carbon::setTestNow('2023-06-08');

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

        DB::table(Visit::tableNameForYear(now()->year))
            ->insert([
                'primary_key' => Str::of($row[1])->replace('visits:triggers', 'visits:testing:triggers')->toString(),
                'secondary_key' => $row[2],
                'score' => (int) $row[3],
                'expired_at' => $row[5] === '' ? null : new Carbon($row[5]),
            ]);
    }

    actingAs($user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/parameters-graph-stats?period=7d')
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('data.period.date', '2023-06-09T00:00:00+00:00')
            ->where('data.period.period', '7d')
            ->has('data.plot.path')
            ->count('data.plot.path', 7)
            ->where('data.plot.path.0.param', '/open')
            ->where('data.plot.path.0.score', 13)
        );
});

it('return expected parameters stats by day', function () use ($visits) {
    Carbon::setTestNow('2023-06-07');

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

        DB::table(Visit::tableNameForYear(now()->year))
            ->insert([
                'primary_key' => Str::of($row[1])->replace('visits:triggers', 'visits:testing:triggers')->toString(),
                'secondary_key' => $row[2],
                'score' => (int) $row[3],
                'expired_at' => $row[5] === '' ? null : new Carbon($row[5]),
            ]);
    }

    actingAs($user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/parameters-graph-stats?period=day')
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('data.period.date', '2023-06-08T00:00:00+00:00')
            ->where('data.period.period', 'day')
            ->has('data.plot.path')
            ->count('data.plot.path', 0)
        );
});
