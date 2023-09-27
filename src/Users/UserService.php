<?php

namespace MetricsWave\Users;

use App\Events\UserServiceCreated;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserService extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'service_id',
        'reconectable',
        'service_data',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'service_id' => 'integer',
        'service_data' => 'array',
    ];

    protected $dispatchesEvents = [
        'created' => UserServiceCreated::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
