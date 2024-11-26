<?php

use App\Models\Trigger;
use App\Models\TriggerType;
use App\Services\Triggers\TriggerParameterStatsGetter;
use App\Transfers\Stats\Period;
use App\Transfers\Stats\PeriodEnum;
use MetricsWave\Metrics\Models\Visit;
use MetricsWave\Teams\Team;

it('return expected visits without params', function () {
    [,$team] = user_with_team();

    $this->travelTo(now()->subMonthNoOverflow());
    $team->triggerNotificationVisits()->increment();

    $this->travelBack();
    $team->triggerNotificationVisits()->increment();

    expect(visitsService(Team::class, Team::TRIGGER_NOTIFICATION)->count())->toBe(2);
    expect(visitsService(Team::class, Team::TRIGGER_NOTIFICATION)->period('month')->count())->toBe(1);
});

it('return expected visits with params', function () {
    [,$team] = user_with_team();
    $trigger = Trigger::factory()
        ->for($team)
        ->for(TriggerType::factory()->create())
        ->create(['uuid' => '3ca54d02-cc2d-4c49-8a72-f46a3681dc62']);

    $this->travelTo(now()->subMonthNoOverflow());
    $team->triggerNotificationVisits()->increment();
    $team->triggerNotificationVisits()->recordParams([
        'user_parameter' => $team->owner->email,
        'team' => $team->domain,
        'plan' => $team->full_subscription_plan_id,
    ], totalOnly: true);

    $this->travelBack();
    $team->triggerNotificationVisits()->increment();
    $team->triggerNotificationVisits()->recordParams([
        'user_parameter' => $team->owner->email,
        'team' => $team->domain,
        'plan' => $team->full_subscription_plan_id,
    ], totalOnly: true);

    $visitsNew = (new Visit)
        ->setTableForYear(now()->year)
        ->setConnection(config('visits.connection'))
        ->get(['primary_key', 'expired_at', 'score'])
        ->toArray();

    $params = app(TriggerParameterStatsGetter::class)->get(
        $trigger,
        new Period(now(), PeriodEnum::month),
        'team'
    );

    expect($params->plot['team'])->toBe([
        ['score' => 1, 'param' => $team->domain],
    ]);
});
