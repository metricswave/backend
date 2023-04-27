<?php

namespace App\Http\Controllers\Trigger;

use App\Http\Controllers\Api\JsonController;
use App\Models\Trigger;
use App\Notifications\TriggerNotification;
use App\Transfers\TriggerTypeId;
use Illuminate\Http\JsonResponse;

class GetWebhookTriggerController extends JsonController
{
    public function __invoke(Trigger $trigger): JsonResponse
    {
        if ($trigger->trigger_type_id !== TriggerTypeId::Webhook->value) {
            return $this->errorResponse('Trigger type is not webhook', 400);
        }

        $params = request()->query();

        $requiredParams = collect($trigger->configuration['fields'])
            ->where('name', 'parameters')
            ->pluck('value')
            ->flatten();

        $missingParams = $requiredParams->diff(array_keys($params));

        if ($missingParams->isNotEmpty()) {
            return $this->errorResponse('Missing parameters: '.$missingParams->implode(', '), 400);
        }

        // Send the webhook notification to user
        $trigger->user->notify(new TriggerNotification($trigger, $params));

        return $this->response([], 204);
    }
}
