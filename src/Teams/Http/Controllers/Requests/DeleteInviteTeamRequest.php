<?php

namespace MetricsWave\Teams\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;
use MetricsWave\Teams\Team;

/**
 * @property string $email
 */
class DeleteInviteTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Team $team */
        $team = $this->route('team');

        return $this->user()->hasAccessToTeam($team->id);
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
        ];
    }
}
