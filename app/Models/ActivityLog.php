<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'aktivitas',
        'modul',
        'method',
        'url',
        'ip_address',
        'browser',
        'device',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}