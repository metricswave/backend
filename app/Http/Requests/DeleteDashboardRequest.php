<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use MetricsWave\Users\User;

class DeleteDashboardRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();

        return $user->hasAccessToTeam($this->route('dashboard')->team);
    }

    public function rules(): array
    {
        return [];
    }
}
