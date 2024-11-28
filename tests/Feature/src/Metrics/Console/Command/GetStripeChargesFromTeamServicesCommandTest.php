<?php

use App\Models\TriggerType;
use App\Transfers\TriggerTypeId;
use MetricsWave\Channels\ChannelId;
use MetricsWave\Channels\TeamChannel;
use MetricsWave\Metrics\Console\Commands\GetStripeChargesFromTeamServicesCommand;
use MetricsWave\Metrics\Models\TeamStripeChannelCharge;
use MetricsWave\Metrics\Models\Visit;

use function Pest\Laravel\artisan;

it('created expected charges', function () {
    [,$team] = user_with_team();
    TriggerType::factory()->create(['id' => TriggerTypeId::Webhook]);
    TeamChannel::factory()->create([
        'channel_id' => ChannelId::Stripe,
        'team_id' => $team->id,
        'data' => [
            'configuration' => ['api_key' => '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'],
        ],
    ]);

    Artisan::registerCommand(new GetStripeChargesFromTeamServicesCommand);
    artisan('visits:stripe');

    $chargesCount = TeamStripeChannelCharge::count();
    expect($chargesCount)->toBeGreaterThan(7);

    $visitsCount = (new Visit)->setTable(Visit::tableNameForYear(now()->year))->setConnection(config('visits.connection'))
        ->where('primary_key', 'visits:testing:triggers_visits_week_amount:1_total')
        ->count();
    expect($visitsCount)->toBeGreaterThan(6);

    artisan('visits:stripe');

    expect(TeamStripeChannelCharge::count())->toBe($chargesCount);

    $afterVisitsCount = (new Visit)->setTable(Visit::tableNameForYear(now()->year))->setConnection(config('visits.connection'))
        ->where('primary_key', 'visits:testing:triggers_visits_week_amount:1_total')
        ->count();
    expect($afterVisitsCount)->toBe($visitsCount);
})->skip('It uses real stripe data');
