<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use Carbon\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\actingAs;

$csv = file_get_contents(__DIR__.'/assets/visits.csv');

$visits = fn (): array => collect(explode("\n", $csv))
    ->map(function ($row) {
        return explode(',', $row);
    })
    ->toArray();

it('return expected array list', function () use ($visits) {
    Date::setTestNow('2023-06-05');

    [$user, $team] = user_with_team();
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create();

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

    actingAs($user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/stats')
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data')
            ->count('data.daily', 22)
            ->count('data.monthly', 0)
        )
        ->assertSuccessful();
});
