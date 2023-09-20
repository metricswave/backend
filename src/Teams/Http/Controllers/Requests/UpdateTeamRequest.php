<?php

namespace MetricsWave\Teams\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;
use MetricsWave\Teams\Team;

/**
 * @property string $domain
 * @property bool $change_dashboard_name
 */
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
            'change_dashboard_name' => ['boolean'],
        ];
    }
}
