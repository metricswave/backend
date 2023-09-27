<?php

namespace MetricsWave\Users\Repositories;

use App\Models\User;
use App\Transfers\ServiceId;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use MetricsWave\Users\UserService;

class UserServiceRepository
{
    public function byServiceIdAndUser(
        ServiceId $serviceId,
        User $user
    ): \Illuminate\Database\Eloquent\Collection|array|Collection {
        return $this->builder()
            ->where('service_id', $serviceId->value)
            ->where('user_id', $user->id)
            ->get();
    }

    public function byServiceId(ServiceId $serviceId): \Illuminate\Database\Eloquent\Collection|array|Collection
    {
        return $this->builder()
            ->where('service_id', $serviceId->value)
            ->get();
    }

    private function builder(): Builder|UserService
    {
        return UserService::query();
    }
}
