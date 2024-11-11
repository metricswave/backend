<?php

namespace MetricsWave\Teams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperMonthlyLimit
 */
class MonthlyLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'month',
        'year',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
