<?php

namespace App\Http\Controllers\Trigger;

use App\Http\Controllers\Api\JsonController;
use App\Models\Trigger;
use App\Services\Triggers\SendWebhookTriggerNotification;
use App\Transfers\TriggerTypeId;
use Exception;
use Illuminate\Http\JsonResponse;

class PostWebhookTriggerController extends JsonController
{
    public function __construct(private readonly SendWebhookTriggerNotification $webhookNotificationSender)
    {
    }

    public function __invoke(Trigger $trigger): JsonResponse
    {
        if ($trigger->trigger_type_id !== TriggerTypeId::Webhook->value) {
            return $this->errorResponse('Trigger type is not webhook', 400);
        }

        $params = request()->all();

        try {
            ($this->webhookNotificationSender)($trigger, $params);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }

        return $this->response([], 204);
    }
}
