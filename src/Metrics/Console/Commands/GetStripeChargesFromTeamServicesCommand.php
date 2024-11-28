<?php

namespace MetricsWave\Metrics\Console\Commands;

use App\Models\Trigger;
use App\Notifications\TriggerNotification;
use Date;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use MetricsWave\Channels\ChannelId;
use MetricsWave\Channels\TeamChannel;
use MetricsWave\Metrics\Models\TeamStripeChannelCharge;
use MetricsWave\Teams\Team;
use MetricsWave\Users\Services\CreateDefaultsForUser;
use Stripe\StripeClient;

class GetStripeChargesFromTeamServicesCommand extends Command
{
    protected $signature = 'visits:stripe {teamId?}';

    protected $description = 'Fetch Stripe Chargers for user Stripe Channels';

    public function handle(): int
    {
        $services = $this->teams($this->argument('teamId'));

        $this->withProgressBar($services, function (TeamChannel $channel) {
            $team = $channel->team;
            $trigger = $this->getOrCreateMoneyAmountTrigger($team);
            $key = $channel->data['configuration']['api_key'];
            $client = new StripeClient($key);
            $charges = $client->charges->all(['limit' => 10]);
            $continue = true;

            do {
                if (! $charges->has_more) {
                    $continue = false;
                }

                foreach ($charges->data as $charge) {
                    $id = $charge->id;
                    $amount = $charge->amount;
                    $user = isset($charge->billing_details->email) ? $charge->billing_details->email : null;
                    $succeeded = $charge->status === 'succeeded';
                    $createdAt = Date::createFromTimestamp($charge->created);

                    if (! $succeeded) {
                        continue;
                    }

                    $alreadyProcessed = TeamStripeChannelCharge::where(['team_id' => $team->id, 'charge_id' => $id])->exists();
                    if ($alreadyProcessed) {
                        $continue = false;

                        break;
                    }

                    $notification = new TriggerNotification($trigger, ['amount' => $amount, 'user' => $user], $createdAt->toImmutable());
                    $team->owner->notify($notification);

                    TeamStripeChannelCharge::create(['team_id' => $team->id, 'charge_id' => $id]);
                }

                if ($continue) {
                    $charges = $client->charges->all(['limit' => 10, 'starting_after' => $id]);
                }
            } while ($continue);
        });

        return self::SUCCESS;
    }

    private function teams(int $teamId = null): Collection
    {
        return TeamChannel::query()
            ->where('channel_id', ChannelId::Stripe)
            ->when(
                $teamId,
                fn ($query) => $query->where('team_id', $teamId),
            )
            ->get();
    }

    private function getOrCreateMoneyAmountTrigger(Team $team): Trigger
    {
        return $team->triggers()->firstOrCreate(
            ['type' => 'money_income'],
            CreateDefaultsForUser::defaultMoneyAmountTriggerParams(),
        );
    }
}
