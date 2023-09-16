<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PutDashboardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('dashboard')->owner->id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'public' => ['nullable', 'boolean'],
            'items' => ['present', 'array'],
            'items.*.eventUuid' => ['required', 'string', 'max:255'],
            'items.*.title' => ['required', 'string', 'max:255'],
            'items.*.size' => ['required', 'string', 'max:255'],
            'items.*.type' => ['required', 'string', 'max:255'],
            'items.*.parameter' => ['nullable', 'string', 'max:255'],
        ];
    }
}
