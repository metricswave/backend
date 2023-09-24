<?php

namespace MetricsWave\Teams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamInvite extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'email',
        'token',
    ];

    protected $dispatchesEvents = [
        'created' => TeamInviteCreated::class,
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
