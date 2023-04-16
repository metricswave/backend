<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteTriggerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('trigger')->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [];
    }
}
