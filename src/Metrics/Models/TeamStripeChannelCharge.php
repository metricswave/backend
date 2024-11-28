<?php

namespace MetricsWave\Metrics\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamStripeChannelCharge extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'charge_id'];
}
