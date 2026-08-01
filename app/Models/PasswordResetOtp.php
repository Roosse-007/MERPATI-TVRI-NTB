<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetOtp extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'attempts',
        'expired_at'
    ];

    protected function casts(): array
    {
        return [
            'expired_at' => 'datetime'
        ];
    }
}