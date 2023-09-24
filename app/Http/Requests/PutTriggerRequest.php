<?php

namespace App\Http\Requests;

use App\Rules\TriggerConfiguration;

class PutTriggerRequest extends TriggerRequest
{
    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();

        return $user->hasAccessToTeam($this->route('trigger')->team);
    }

    public function rules(): array
    {
        return [
            'emoji' => 'string|max:255',
            'title' => 'string|max:255',
            'content' => 'string|max:255',
            'configuration' => ['array', new TriggerConfiguration()],
            'via' => ['array'],
        ];
    }
}
