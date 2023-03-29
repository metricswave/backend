<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository
{
    public function firstByEmail(string $email): User
    {
        return $this->builder()
            ->where('email', $email)
            ->firstOrFail();
    }

    private function builder(): Builder|User
    {
        return User::query();
    }

    public function create(string $name, string $email, string $password): User
    {
        return $this->builder()->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }
}
