<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteUserServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('userService')->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [];
    }
}
