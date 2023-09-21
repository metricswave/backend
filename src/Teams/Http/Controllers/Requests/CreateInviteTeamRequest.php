<?php

namespace MetricsWave\Teams\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;
use MetricsWave\Teams\Team;

/**
 * @property string $email
 */
class CreateInviteTeamRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', 'not_in:'.$this->user()->email, 'unique:team_invites,email'],
        ];
    }
}
