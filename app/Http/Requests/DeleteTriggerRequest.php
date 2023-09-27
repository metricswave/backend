<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use MetricsWave\Users\User;

class DeleteTriggerRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();

        return $user->hasAccessToTeam($this->route('trigger')->team);
    }

    public function rules(): array
    {
        return [];
    }
}
