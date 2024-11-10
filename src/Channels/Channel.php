<?php

namespace MetricsWave\Channels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperChannel
 */
class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'driver',
        'description',
        'configuration',
    ];

    protected $casts = [
        'configuration' => 'json',
    ];
}
