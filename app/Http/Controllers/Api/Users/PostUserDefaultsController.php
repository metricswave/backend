<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\ApiAuthJsonController;
use App\Models\Trigger;
use App\Transfers\TriggerTypeId;
use Illuminate\Http\JsonResponse;
use Str;

class PostUserDefaultsController extends ApiAuthJsonController
{
    public function __invoke(): JsonResponse
    {
        if ($this->user()->triggers()->count() > 0) {
            return $this->noContentResponse();
        }

        /** @var Trigger $trigger */
        $trigger = $this->user()->triggers()->create([
            'trigger_type_id' => TriggerTypeId::Webhook,
            'uuid' => Str::uuid(),
            'emoji' => '📊',
            'title' => 'New visit',
            'content' => 'Path {path}',
            'configuration' => [
                'version' => '1.0',
                'fields' => [
                    'parameters' => ['path', 'language', 'userAgent', 'platform', 'referrer']
                ],
            ],
            'via' => [],
        ]);

        $this->user()->dashboards()->create([
            'name' => 'Default',
            'items' => [
                [
                    "size" => "large",
                    "type" => "stats",
                    "title" => "Visits",
                    "eventUuid" => $trigger->uuid,
                    "parameter" => null
                ],
                [
                    "size" => "base",
                    "type" => "parameter",
                    "title" => "Paths",
                    "eventUuid" => $trigger->uuid,
                    "parameter" => null
                ],
                [
                    "size" => "base",
                    "type" => "parameter",
                    "title" => "Languages",
                    "eventUuid" => $trigger->uuid,
                    "parameter" => "language"
                ]
            ],
        ]);

        return $this->createdResponse();
    }
}
