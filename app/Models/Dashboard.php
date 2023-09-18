<?php

namespace App\Models;

use App\Transfers\Dashboard\DashboardItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use MetricsWave\Teams\Team;
use Spatie\LaravelData\DataCollection;

class Dashboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'public',
        'uuid',
        'team_id',
        'items',
    ];

    protected $casts = [
        'items' => DataCollection::class.':'.DashboardItem::class,
        'public' => 'boolean',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function owner(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Team::class, 'id', 'id', 'team_id', 'owner_id');
    }

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Team::class);
    }
}
