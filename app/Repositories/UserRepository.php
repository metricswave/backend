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
}
