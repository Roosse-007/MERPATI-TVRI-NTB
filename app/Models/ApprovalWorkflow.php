<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalWorkflow extends Model
{
    protected $table = 'approval_workflows';

    protected $fillable = [
        'jenis_surat_id',
        'jabatan_id',
        'urutan',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Jenis Surat
    |--------------------------------------------------------------------------
    */

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(
            JenisSurat::class,
            'jenis_surat_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Jabatan
    |--------------------------------------------------------------------------
    */

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(
            Jabatan::class,
            'jabatan_id'
        );
    }
    public function approvals(): HasMany
    {
        return $this->hasMany(
            Approval::class,
            'approval_workflow_id'
        );
    }
}