<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteDashboardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('dashboard')->owner->id === $this->user()->id;
    }

    public function rules(): array
    {
        return [];
    }
}
