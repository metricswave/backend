<?php

namespace MetricsWave\Users\Repositories;

use App\Exceptions\CanNotCreateUserBecauseNoPaidLicence;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function firstByEmail(string $email): User
    {
        return $this->builder()
            ->where('email', $email)
            ->firstOrFail();
    }

    public function userByToken(string $token): User
    {
        return $this->builder()
            ->whereRaw('md5(email) = ?', [$token])
            ->firstOrFail();
    }

    public function updateOrCreate(string $email, array $data): User
    {
        if (
            (
                config('feature.sign_up_leads_only')
                && ! Lead::query()->where('email', $email)->whereNotNull('paid_at')->exists()
            )
            && ! $this->builder()->where('email', $email)->exists()
        ) {
            throw new CanNotCreateUserBecauseNoPaidLicence();
        }

        return $this->builder()
            ->updateOrCreate(['email' => $email], $data);
    }

    public function create(string $name, string $email, string $password): User
    {
        if (
            config('feature.sign_up_leads_only')
            && ! Lead::query()->where('email', $email)->whereNotNull('paid_at')->exists()
        ) {
            throw new CanNotCreateUserBecauseNoPaidLicence();
        }

        return $this->builder()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }

    private function builder(): Builder|User
    {
        return User::query();
    }
}
