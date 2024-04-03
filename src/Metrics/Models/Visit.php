<?php

namespace MetricsWave\Metrics\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $connection = 'visits';

    protected $guarded = [];

    protected $casts = ['list' => 'array', 'expired_at' => 'datetime'];
}
