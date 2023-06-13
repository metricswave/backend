<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use Awssat\Visits\Models\Visit;

$csv = file_get_contents(__DIR__.'/assets/expire_params.csv');
$visits = fn(): array => collect(explode("\n", $csv))
    ->map(function ($row) {
        return explode(',', $row);
    })
    ->toArray();

it('increase visits and set expired_at dates as expected', function () {
    $user = User::factory()->create();

    $startDate = Date::createFromDate('1989', '10', '23')->startOfDay()->subDay();
    $this->travelTo($startDate);
    $user->triggerNotificationVisits()->increment();

    foreach (range(1, 5) as $i) {
        $this->travelTo($startDate->addRealDay());
        $user->triggerNotificationVisits()->increment();
    }

    $visits = Visit::query()->where('secondary_key', $user->id)->get([
        'primary_key',
        'expired_at',
        'score',
    ])->toArray();

    expect($visits)->toHaveCount(11);
});

it('increase visits with params and set expired_at dates as expected', function () {
    $trigger = Trigger::factory()
        ->for(User::factory()->create())
        ->for(TriggerType::factory()->create())
        ->create([
            'id' => 48,
            'configuration' => [
                'fields' => ['parameters' => ['path', 'referrer']],
            ],
        ]);

    $startDate = Date::createFromDate('1989', '10', '23')->startOfDay()->subDay();
    $this->travelTo($startDate);

    $trigger->visits()->recordParams(['path' => 'testing', 'referrer' => 'https://google.com']);

    foreach (range(1, 5) as $i) {
        $this->travelTo($startDate->addRealDay());
        $trigger->visits()->recordParams(['path' => 'testing', 'referrer' => 'https://google.com']);
    }

    $visits = $trigger->visits()->period('day')->countAllByParam(
        'referrer',
        Date::createFromDate('1989', '10', '23')->startOfDay()
    );

    expect($visits->count())->toBe(1);
});

it('fails because unique index violation', function () {
    $user = User::factory()->create();

    Visit::create([
        'primary_key' => 'visits:testing:users_triggernotification_day',
        'secondary_key' => 1,
        'score' => 10,
        'expired_at' => now()->addDay()->startOfDay(),
    ]);

    Visit::create([
        'primary_key' => 'visits:testing:users_triggernotification_day',
        'secondary_key' => 1,
        'score' => 10,
        'expired_at' => null,
    ]);

    $user->triggerNotificationVisits()->increment();

    $visits = Visit::query()
        ->where('primary_key', 'visits:testing:users_triggernotification_day')
        ->where('secondary_key', $user->id)->get([
            'primary_key',
            'expired_at',
            'score',
        ])->toArray();

    expect($visits)->toBe([
        [
            'primary_key' => 'visits:testing:users_triggernotification_day',
            'expired_at' => now()->addDay()->startOfDay()->toIso8601ZuluString('microseconds'),
            'score' => 21,
        ],
    ]);
});

it('should set expire date on each visit', function () use ($visits) {
    $trigger = Trigger::factory()
        ->for(User::factory()->create())
        ->for(TriggerType::factory()->create())
        ->create([
            'id' => 48,
            'configuration' => [
                'fields' => ['parameters' => ['path', 'referrer']],
            ],
        ]);

    $this->travelTo(Date::createFromDate('1989', '10', '23')->startOfDay()->addHour());

    foreach ($visits() as $row) {
        if (count($row) === 1) {
            continue;
        }

        DB::table('visits')
            ->insert([
                'primary_key' => Str::of($row[1])->replace('visits:triggers', 'visits:testing:triggers')->toString(),
                'secondary_key' => $row[2] !== "" ? $row[2] : null,
                'score' => (int) $row[3],
                'expired_at' => null,
            ]);
    }

    $trigger->visits()->recordParams(['path' => 'testing', 'referrer' => 'https://google.com']);

    expect(Visit::query()->whereNull('expired_at')->count())->toBe(0);
});


