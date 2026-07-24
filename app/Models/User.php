<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'unit_kerja_id',
        'jabatan_id',
        'nip',
        'username',
        'foto',
        'tte_file',
        'is_active',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime',
            'is_active' => 'boolean',
        ];
    }


    public function pengesahanSurat(): HasMany
{

    return $this->hasMany(
        PengesahanSurat::class,
        'user_id'
    );

}
    public function unitKerja(): BelongsTo
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function surat(): HasMany
    {
        return $this->hasMany(Surat::class, 'pengirim_id');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class, 'approver_id');
    }

    public function disposisiDari(): HasMany
    {
        return $this->hasMany(Disposisi::class, 'dari_user_id');
    }

    public function disposisiKe(): HasMany
    {
        return $this->hasMany(Disposisi::class, 'ke_user_id');
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }
}