<?php

namespace App\Http\Requests;

use App\Rules\TriggerConfiguration;
use Date;
use Illuminate\Foundation\Http\FormRequest;

class PutTriggerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('trigger')->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'emoji' => 'string|max:255',
            'title' => 'string|max:255',
            'content' => 'string|max:255',
            'configuration' => ['array', new TriggerConfiguration()],
            'via' => ['array']
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
