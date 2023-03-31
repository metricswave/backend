<?php

namespace App\Models;

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
    ];

    protected $casts = [
        'scopes' => 'array',
    ];

    public function userServices(): HasMany
    {
        return $this->hasMany(UserService::class);
    }
}
