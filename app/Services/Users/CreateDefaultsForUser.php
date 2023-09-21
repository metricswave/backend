<?php

namespace App\Services\Users;

use App\Models\Trigger;
use App\Transfers\TriggerTypeId;
use MetricsWave\Teams\Team;
use Str;

class CreateDefaultsForUser
{
    public function __invoke(Team $team, string $dashboardName = null): void
    {
        /** @var Trigger $trigger */
        $trigger = $team->triggers()->create([
            'trigger_type_id' => TriggerTypeId::Webhook,
            'uuid' => Str::uuid(),
            'emoji' => '📊',
            'title' => 'New visit',
            'content' => 'Path {path}',
            'configuration' => [
                'version' => '1.0',
                'type' => 'visits',
                'fields' => [
                    'parameters' => Trigger::VISITS_PARAMS,
                ],
            ],
            'via' => [],
        ]);

        $team->dashboards()->create([
            'name' => $dashboardName ?? 'Default',
            'items' => [
                [
                    'size' => 'large',
                    'type' => 'stats',
                    'title' => 'Visits',
                    'eventUuid' => $trigger->uuid,
                    'parameter' => null,
                ],
                [
                    'size' => 'base',
                    'type' => 'parameter',
                    'title' => 'Paths',
                    'eventUuid' => $trigger->uuid,
                    'parameter' => null,
                ],
                [
                    'size' => 'base',
                    'type' => 'parameter',
                    'title' => 'Languages',
                    'eventUuid' => $trigger->uuid,
                    'parameter' => 'language',
                ],
                [
                    'size' => 'base',
                    'type' => 'parameter',
                    'title' => 'UTM Source',
                    'eventUuid' => $trigger->uuid,
                    'parameter' => 'utm_source',
                ],
                [
                    'size' => 'base',
                    'type' => 'parameter',
                    'title' => 'Referrer',
                    'eventUuid' => $trigger->uuid,
                    'parameter' => 'referrer',
                ],
            ],
        ]);
    }
}
