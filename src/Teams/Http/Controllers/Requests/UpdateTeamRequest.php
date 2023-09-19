<?php

namespace MetricsWave\Teams\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;
use MetricsWave\Teams\Team;

class UpdateTeamRequest extends FormRequest
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
            'domain' => ['required', 'string', 'max:255'],
        ];
    }
}
