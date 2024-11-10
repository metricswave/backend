<?php

namespace MetricsWave\Users;

use App\Models\User;
use App\Transfers\ServiceId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperUserCalendar
 */
class UserCalendar extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'service_id',
        'calendar_id',
        'name',
        'description',
        'background_color',
        'foreground_color',
        'time_zone',
        'updated_at',
    ];

    protected $casts = [
        'service_id' => ServiceId::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(UserService::class);
    }
}
