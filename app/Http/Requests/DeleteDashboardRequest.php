<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

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
