<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

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
