<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\actingAs;

$csv = file_get_contents(__DIR__.'/assets/visits_parameters.csv');
$visits = fn(): array => collect(explode("\n", $csv))->map(fn($row) => explode(',', $row))->toArray();

it('return expected parameters stats when trigger has no params', function () use ($visits) {
    $trigger = Trigger::factory()
        ->for(User::factory()->create())
        ->for(TriggerType::factory()->create())
        ->create(['id' => 48]);

    actingAs($trigger->user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/parameters-graph-stats')
        ->assertJson([])
        ->assertSuccessful();
});

it('return expected parameters stats', function () use ($visits) {
    $trigger = Trigger::factory()
        ->for(User::factory()->create())
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

        DB::table('visits')
            ->insert([
                'primary_key' => Str::of($row[1])->replace('visits:triggers', 'visits:testing:triggers')->toString(),
                'secondary_key' => $row[2],
                'score' => (int) $row[3],
                'expired_at' => $row[5] === "" ? null : new Carbon($row[5]),
            ]);
    }

    actingAs($trigger->user)
        ->getJson('/api/triggers/'.$trigger->uuid.'/parameters-graph-stats?date=2023-06-08')
        ->assertJson(fn(AssertableJson $json) => $json
            ->where('data.period.date', '2023-07-01')
            ->where('data.period.period', '30d')
            ->has('data.plot.path')
            ->count('data.plot.path', 3)
            ->where('data.plot.path.0.param', '/')
            ->where('data.plot.path.0.score', 3)
        )
        ->assertSuccessful();
});

