<?php

namespace App\Services\Triggers;

use App\Jobs\TeamTriggerNotificationJob;
use App\Models\Trigger;
use App\Notifications\TriggerNotification;
use Carbon\CarbonImmutable;

class SendWebhookTriggerNotification
{
    /**
     * @throws MissingTriggerParams
     */
    public function __invoke(Trigger $trigger, array $params, bool $fromScript = false, ?string $triggeredAt = null): void
    {
        if ($trigger->team_id === 76) {
            return;
        }

        $missingParams = $this->missingParams($trigger, $params);

        if ($missingParams->isNotEmpty() && ! $fromScript) {
            throw MissingTriggerParams::with($missingParams);
        }

        if ($trigger->team === null) {
            return;
        }

        $triggeredAt = $triggeredAt !== null ? CarbonImmutable::parse($triggeredAt) : null;

        TeamTriggerNotificationJob::dispatch(
            $trigger->team,
            new TriggerNotification(
                $trigger,
                $params,
                $triggeredAt,
            )
        );
    }

    private function missingParams(Trigger $trigger, array $params): \Illuminate\Support\Collection
    {
        $requiredParams = collect($trigger->configuration['fields']['parameters'])
            ->reject(fn ($param) => $param === 'user_id');

        return $requiredParams->diff(array_keys($params));
    }
}
