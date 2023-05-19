<?php

namespace App\Models;

use App\Events\ServiceCreated;
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
}
