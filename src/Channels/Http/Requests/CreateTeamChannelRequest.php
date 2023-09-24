<?php

namespace MetricsWave\Channels\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int channel_id
 * @property array fields
 */
class CreateTeamChannelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'channel_id' => ['required', 'integer'],
            'fields' => ['required', 'array'],
        ];
    }
}
