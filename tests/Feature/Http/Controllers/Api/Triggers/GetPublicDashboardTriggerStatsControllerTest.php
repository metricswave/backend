<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\getJson;

$csv = file_get_contents(__DIR__.'/assets/visits.csv');

$visits = fn (): array => collect(explode("\n", $csv))
    ->map(function ($row) {
        return explode(',', $row);
    })
    ->toArray();

it('return expected array list', function () use ($visits) {
    Date::setTestNow('2023-06-05');

    $dashboard = dashboard(['public' => true]);

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
                'expired_at' => $row[5] === '' ? null : new Carbon($row[5]),
            ]);
    }

    getJson('/api/dashboards/'.$dashboard->uuid.'/triggers/'.$trigger->uuid.'/stats')
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data')
            ->count('data.daily', 22)
            ->count('data.monthly', 0)
        )
        ->assertSuccessful();
});

it('return 404 if trigger is not public', function () {
    Date::setTestNow('2023-06-05');

    $dashboard = dashboard(['public' => true]);

    $trigger = Trigger::factory()
        ->for(User::factory()->create())
        ->for(TriggerType::factory()->create())
        ->create(['uuid' => 'random']);

    getJson('/api/dashboards/'.$dashboard->uuid.'/triggers/'.$trigger->uuid.'/stats')
        ->assertNotFound();
});
