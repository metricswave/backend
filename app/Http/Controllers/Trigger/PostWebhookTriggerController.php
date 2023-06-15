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
    use UseTriggerVisitsUpdater;

    public function __construct(private readonly SendWebhookTriggerNotification $webhookNotificationSender)
    {
    }

    public function __invoke(Trigger $trigger): JsonResponse
    {
        if ($trigger->trigger_type_id !== TriggerTypeId::Webhook->value) {
            return $this->errorResponse('Trigger type is not webhook', 400);
        }

        $fromScript = request()->post('f', false) === 'script';
        $this->checkTrigger($fromScript, $trigger);

        $params = request()->post();

        try {
            ($this->webhookNotificationSender)($trigger, $params, $fromScript);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }

        return $this->response([], 204);
    }
}
