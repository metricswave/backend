<?php

namespace App\Models;

use App\Transfers\Dashboard\DashboardItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\LaravelData\DataCollection;

class Dashboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'items',
    ];

    protected $casts = [
        'items' => DataCollection::class.':'.DashboardItem::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
