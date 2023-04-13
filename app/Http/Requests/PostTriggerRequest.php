<?php

namespace App\Http\Requests;

use App\Rules\TriggerConfiguration;
use Illuminate\Foundation\Http\FormRequest;

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
}
