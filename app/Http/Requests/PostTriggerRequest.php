<?php

namespace App\Http\Requests;

use App\Rules\TriggerConfiguration;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;

class PostTriggerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid' => 'required|string|max:255|unique:triggers,uuid',
            'trigger_type_id' => 'required|integer|exists:trigger_types,id',
            'emoji' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'configuration' => ['required', 'array', new TriggerConfiguration()],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $validData = parent::validated($key, $default);

        if (isset($validData['configuration']['fields']['time'])) {
            $time = $this->timeToUtc($validData['configuration']['fields']['time']);
            $validData['configuration']['fields']['time'] = $time;
        }

        return $validData;
    }

    private function timeToUtc(string $time): string
    {
        $timezone = request()->header('x-timezone', 'UTC');
        $date = Date::createFromFormat('H:i', $time, $timezone)->setTimezone('UTC');

        return $date->format('H:i');
    }
}
