<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\User;
use MetricsWave\Metrics\Models\Visit;
use MetricsWave\Teams\Team;

use function Pest\Laravel\postJson;

$csv = file_get_contents(__DIR__.'/assets/expire_params.csv');
$visits = fn (): array => collect(explode("\n", $csv))
    ->map(function ($row) {
        return explode(',', $row);
    })
    ->toArray();

it('increase visits and set expired_at dates as expected', function () {
    $user = User::factory()->create(['id' => 1]);

    $startDate = Date::createFromDate('1989', '10', '23')->startOfDay()->subDay();
    $this->travelTo($startDate);
    $user->triggerNotificationVisits()->increment();

    foreach (range(1, 5) as $i) {
        $this->travelTo($startDate->addRealDay());
        $user->triggerNotificationVisits()->increment();
    }

    $visits = (new Visit())
        ->setTableForYear(now()->year)
        ->setConnection(config('visits.connection'))
        ->where('secondary_key', $user->id)
        ->get(['primary_key', 'expired_at', 'score'])
        ->toArray();

    $visitsNew = (new Visit())
        ->setTableForYear(2024)
        ->setConnection(config('visits.connection'))
        ->where('secondary_key', $user->id)
        ->get(['primary_key', 'expired_at', 'score'])
        ->toArray();

    expect($visits)->toHaveCount(11);
});

it('increase visits with params and set expired_at dates as expected', function () {
    $trigger = Trigger::factory()
        ->for(Team::factory()->create(['id' => 1]))
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
    [$user, $team] = user_with_team(['id' => 1]);

    $visits = new Visit([
        'primary_key' => 'visits:testing:users_triggernotification_day',
        'secondary_key' => 1,
        'score' => 20,
        'expired_at' => now()->addDay()->startOfDay(),
    ]);
    $visits->setTable(Visit::tableNameForYear(now()->year))->setConnection(config('visits.connection'))->save();

    $user->triggerNotificationVisits()->increment();

    $visits = (new Visit())->setTable(Visit::tableNameForYear(now()->year))->setConnection(config('visits.connection'))
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

it('store visits params, unique visits and new visits', function () {
    [$user, $team] = user_with_team();
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create([
            'id' => 48,
            'configuration' => [
                'version' => '1.0',
                'type' => 'visits',
                'fields' => [
                    'parameters' => Trigger::VISITS_PARAMS,
                ],
            ],
        ]);

    postJson('/webhooks/'.$trigger->uuid, [
        'path' => '/blog',
        'visit' => 1,
        'deviceName' => 'any-device-name',
        'domain' => 'metricswave.com',
        'language' => 'en-US',
        'userAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
        'platform' => 'MacIntel',
        'referrer' => '',
        'utm_source' => null,
        'utm_medium' => null,
        'utm_campaign' => null,
        'utm_term' => null,
        'utm_content' => null,
    ]);

    postJson('/webhooks/'.$trigger->uuid, [
        'path' => '/',
        'visit' => 0,
        'deviceName' => 'any-device-name',
        'domain' => 'metricswave.com',
        'language' => 'en-US',
        'userAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
        'platform' => 'MacIntel',
        'referrer' => 'https://metricswave.com/blog',
        'utm_source' => null,
        'utm_medium' => null,
        'utm_campaign' => null,
        'utm_term' => null,
        'utm_content' => null,
    ]);

    postJson('/webhooks/'.$trigger->uuid, [
        'path' => '/documentation',
        'visit' => 0,
        'deviceName' => 'any-device-name',
        'domain' => 'metricswave.com',
        'language' => 'en-US',
        'userAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
        'platform' => 'MacIntel',
        'referrer' => 'https://metricswave.com/',
        'utm_source' => null,
        'utm_medium' => null,
        'utm_campaign' => null,
        'utm_term' => null,
        'utm_content' => null,
    ]);

    postJson('/webhooks/'.$trigger->uuid, [
        'path' => '/blog',
        'visit' => 1,
        'deviceName' => 'any-device-name',
        'domain' => 'metricswave.com',
        'language' => 'en-US',
        'userAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
        'platform' => 'MacIntel',
        'referrer' => '',
        'utm_source' => null,
        'utm_medium' => null,
        'utm_campaign' => null,
        'utm_term' => null,
        'utm_content' => null,
    ]);

    expect(
        (new Visit())->setTable(Visit::tableNameForYear(now()->year))->setConnection(config('visits.connection'))
            ->where('primary_key', 'visits:testing:triggers_unique_visits_day')
            ->where('secondary_key', $trigger->id)
            ->get('score')
            ->first()
            ->score
    )->toBe(1);

    expect(
        (new Visit())->setTable(Visit::tableNameForYear(now()->year))->setConnection(config('visits.connection'))
            ->where('primary_key', 'visits:testing:triggers_new_visits_day')
            ->where('secondary_key', $trigger->id)
            ->get('score')
            ->first()
            ->score
    )->toBe(2);

    expect(
        (new Visit())->setTable(Visit::tableNameForYear(now()->year))->setConnection(config('visits.connection'))
            ->where('primary_key', 'visits:testing:triggers_visits_day_referrer:48')
            ->where('secondary_key', '!=', 'Direct / None')
            ->exists()
    )->toBeFalse();
});

it('store visits referrer', function () {
    [$user, $team] = user_with_team(teamAttributes: ['id' => 1]);
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create([
            'id' => 48,
            'configuration' => [
                'version' => '1.0',
                'type' => 'visits',
                'fields' => [
                    'parameters' => Trigger::VISITS_PARAMS,
                ],
            ],
        ]);

    postJson('/webhooks/'.$trigger->uuid, [
        'path' => '/blog',
        'domain' => 'metricswave.com',
        'language' => 'en-US',
        'userAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
        'platform' => 'MacIntel',
        'referrer' => 'https://google.com',
        'utm_source' => null,
        'utm_medium' => null,
        'utm_campaign' => null,
        'utm_term' => null,
        'utm_content' => null,
    ]);

    postJson('/webhooks/'.$trigger->uuid, [
        'path' => '/blog',
        'domain' => 'metricswave.com',
        'language' => 'en-US',
        'userAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
        'platform' => 'MacIntel',
        'referrer' => '',
        'utm_source' => null,
        'utm_medium' => null,
        'utm_campaign' => null,
        'utm_term' => null,
        'utm_content' => null,
    ]);

    expect(
        (new Visit())->setTable(Visit::tableNameForYear(now()->year))->setConnection(config('visits.connection'))
            ->where('primary_key', 'visits:testing:triggers_visits_day_referrer:48')
            ->where('secondary_key', 'https://google.com')
            ->get('score')
            ->first()
            ->score
    )->toBe(1);
});

it('visit type works even when it has no params', function () {
    [$user, $team] = user_with_team(teamAttributes: ['id' => 1]);
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create([
            'id' => 48,
            'configuration' => [
                'version' => '1.0',
                'type' => 'visits',
                'fields' => [
                    'parameters' => [],
                ],
            ],
        ]);

    postJson('/webhooks/'.$trigger->uuid, [
        'path' => '/blog',
        'visit' => 1,
        'deviceName' => 'any-device-name',
        'domain' => 'metricswave.com',
        'language' => 'en-US',
        'userAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
        'platform' => 'MacIntel',
        'referrer' => '',
    ]);

    postJson('/webhooks/'.$trigger->uuid, [
        'path' => '/',
        'visit' => 0,
        'deviceName' => 'any-device-name',
        'domain' => 'metricswave.com',
        'language' => 'en-US',
        'userAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
        'platform' => 'MacIntel',
        'referrer' => 'https://metricswave.com/blog',
    ]);

    postJson('/webhooks/'.$trigger->uuid, [
        'path' => '/documentation',
        'deviceName' => 'any-device-name',
        'visit' => 0,
        'domain' => 'metricswave.com',
        'language' => 'en-US',
        'userAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
        'platform' => 'MacIntel',
        'referrer' => 'https://metricswave.com/',
    ]);

    postJson('/webhooks/'.$trigger->uuid, [
        'path' => '/blog',
        'deviceName' => 'any-device-name',
        'visit' => 1,
        'domain' => 'metricswave.com',
        'language' => 'en-US',
        'userAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
        'platform' => 'MacIntel',
        'referrer' => '',
    ]);

    expect(
        (new Visit())->setTable(Visit::tableNameForYear(now()->year))->setConnection(config('visits.connection'))
            ->where('primary_key', 'visits:testing:triggers_visits_day_language:48')
            ->where('secondary_key', 'en-US')
            ->get('score')
            ->first()
            ->score
    )->toBe(4);

    expect(
        (new Visit())->setTable(Visit::tableNameForYear(now()->year))->setConnection(config('visits.connection'))
            ->where('primary_key', 'visits:testing:triggers_unique_visits_day')
            ->where('secondary_key', $trigger->id)
            ->get('score')
            ->first()
            ->score
    )->toBe(1);

    expect(
        (new Visit())->setTable(Visit::tableNameForYear(now()->year))->setConnection(config('visits.connection'))
            ->where('primary_key', 'visits:testing:triggers_new_visits_day')
            ->where('secondary_key', $trigger->id)
            ->get('score')
            ->first()
            ->score
    )->toBe(2);

    expect(
        (new Visit())->setTable(Visit::tableNameForYear(now()->year))->setConnection(config('visits.connection'))
            ->where('primary_key', 'visits:testing:triggers_visits_day_referrer:48')
            ->where('secondary_key', '!=', 'Direct / None')
            ->exists()
    )->toBeFalse();
});
