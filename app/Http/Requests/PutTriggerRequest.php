<?php

namespace App\Http\Requests;

use App\Rules\TriggerConfiguration;
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
        ];
    }
}
