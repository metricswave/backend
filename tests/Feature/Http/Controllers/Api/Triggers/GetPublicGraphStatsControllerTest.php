<?php

use App\Models\Dashboard;
use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\actingAs;

$csv = file_get_contents(__DIR__.'/assets/visits.csv');

$visits = fn(): array => collect(explode("\n", $csv))
    ->map(function ($row) {
        return explode(',', $row);
    })
    ->toArray();

it('return expected data', function () use ($visits) {
    Date::setTestNow('2023-06-05');

    $dashboard = Dashboard::factory()
        ->for(User::factory()->create())
        ->create(['public' => true]);

    $trigger = Trigger::factory()
        ->for(User::factory()->create())
        ->for(TriggerType::factory()->create())
        ->create(['uuid' => $dashboard->items[0]->eventUuid]);

    foreach ($visits() as $row) {
        if (count($row) === 1) {
            continue;
        }

        DB::table('visits')
            ->insert([
                'primary_key' => 'visits:testing:triggers_visits_day',
                'secondary_key' => $trigger->id,
                'score' => (int) $row[3],
                'expired_at' => $row[5] === "" ? null : new Carbon($row[5]),
            ]);
    }

    actingAs($trigger->user)
        ->getJson('/api/dashboards/'.$dashboard->uuid.'/triggers/'.$trigger->uuid.'/graph-stats')
        ->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->where('data.period.date', '2023-06-06T00:00:00+00:00')
            ->where('data.period.period', '30d')
            ->count('data.plot', 21)
            ->where('data.plot.0.date', '2023-06-05T00:00:00+00:00')
            ->where('data.plot.0.score', 2)
        );
});

it('return expected data for week period', function () use ($visits) {
    Date::setTestNow('2023-06-05');

    $dashboard = Dashboard::factory()
        ->for(User::factory()->create())
        ->create(['public' => true]);

    $trigger = Trigger::factory()
        ->for(User::factory()->create())
        ->for(TriggerType::factory()->create())
        ->create(['uuid' => $dashboard->items[0]->eventUuid]);

    foreach ($visits() as $row) {
        if (count($row) === 1) {
            continue;
        }

        DB::table('visits')
            ->insert([
                'primary_key' => 'visits:testing:triggers_visits_day',
                'secondary_key' => $trigger->id,
                'score' => (int) $row[3],
                'expired_at' => $row[5] === "" ? null : new Carbon($row[5]),
            ]);
    }

    actingAs($trigger->user)
        ->getJson('/api/dashboards/'.$dashboard->uuid.'/triggers/'.$trigger->uuid.'/graph-stats?period=7d')
        ->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->where('data.period.date', '2023-06-06T00:00:00+00:00')
            ->where('data.period.period', '7d')
            ->count('data.plot', 7)
            ->where('data.plot.0.date', '2023-06-05T00:00:00+00:00')
            ->where('data.plot.0.score', 2)
        );
});

it('return expected data for year period', function () use ($visits) {
    Date::setTestNow('2023-06-05');

    $dashboard = Dashboard::factory()
        ->for(User::factory()->create())
        ->create(['public' => true]);

    $trigger = Trigger::factory()
        ->for(User::factory()->create())
        ->for(TriggerType::factory()->create())
        ->create(['uuid' => $dashboard->items[0]->eventUuid]);

    foreach ($visits() as $row) {
        if (count($row) === 1) {
            continue;
        }

        DB::table('visits')
            ->insert([
                'primary_key' => 'visits:testing:triggers_visits_day',
                'secondary_key' => $trigger->id,
                'score' => (int) $row[3],
                'expired_at' => $row[5] === "" ? null : new Carbon($row[5]),
            ]);
    }

    actingAs($trigger->user)
        ->getJson('/api/dashboards/'.$dashboard->uuid.'/triggers/'.$trigger->uuid.'/graph-stats?period=12m')
        ->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->where('data.period.date', '2023-07-01T00:00:00+00:00')
            ->where('data.period.period', '12m')
            ->count('data.plot', 0)
        );
});
