<?php

namespace MetricsWave\Teams\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $domain
 */
class CreateTeamRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'domain' => ['required', 'string', 'max:255'],
        ];
    }
}
