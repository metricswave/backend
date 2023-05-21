<?php

namespace App\Models;

use App\Events\ServiceCreated;
use App\Transfers\ServiceId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'driver',
        'description',
        'scopes',
        'multiple',
        'configuration',
    ];

    protected $casts = [
        'scopes' => 'array',
        'multiple' => 'boolean',
        'configuration' => 'json',
    ];

    protected $dispatchesEvents = [
        'created' => ServiceCreated::class,
    ];

    public function userServices(): HasMany
    {
        return $this->hasMany(UserService::class);
    }

    public function scopesFor(bool $creating): array
    {
        if ($this->id === ServiceId::Google->value && $creating) {
            return array_diff($this->scopes, [
                'https://www.googleapis.com/auth/calendar.readonly',
                'https://www.googleapis.com/auth/calendar.events.readonly'
            ]);
        }

        return $this->scopes;
    }
}
