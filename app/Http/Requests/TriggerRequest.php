<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;

class TriggerRequest extends FormRequest
{
    private const TIME_FIELDS = [
        'time',
        'arrival_time',
    ];

    public function validated($key = null, $default = null): array
    {
        $validData = parent::validated($key, $default);

        foreach (self::TIME_FIELDS as $field) {
            if (isset($validData['configuration']['fields'][$field])) {
                $time = $this->timeToUtc($validData['configuration']['fields'][$field]);
                $validData['configuration']['fields'][$field] = $time;
            }
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
