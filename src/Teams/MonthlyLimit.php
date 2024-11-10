<?php

namespace MetricsWave\Teams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'month',
        'year',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
