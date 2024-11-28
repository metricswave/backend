<?php

namespace MetricsWave\Channels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use MetricsWave\Teams\Team;

/**
 * @mixin IdeHelperTeamChannel
 */
class TeamChannel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'team_id',
        'channel_id',
        'data',
    ];

    protected $casts = [
        'data' => 'json',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
