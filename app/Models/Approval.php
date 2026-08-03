<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Approval extends Model
{

    protected $table = 'approval';


    protected $fillable = [
        'surat_id',
        'approval_workflow_id',
        'approver_id',
        'urutan',
        'status',
        'catatan',
        'approved_at',
    ];



    protected function casts(): array
    {
        return [

            'approved_at'=>'datetime',

        ];
    }




    public function surat(): BelongsTo
    {
        return $this->belongsTo(
            Surat::class,
            'surat_id'
        );
    }




    public function approver(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'approver_id'
        );
    }

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(
            ApprovalWorkflow::class,
            'approval_workflow_id'
        );
    }

    /*
|--------------------------------------------------------------------------
| Badge Color
|--------------------------------------------------------------------------
*/

public function getBadgeColorAttribute(): string
{
    return match ($this->status) {

        'Disetujui' => 'green',

        'Ditolak' => 'red',

        'Menunggu' => 'yellow',

        default => 'gray',

    };
}

/*
|--------------------------------------------------------------------------
| Icon
|--------------------------------------------------------------------------
*/

public function getIconAttribute(): string
{
    return match ($this->status) {

        'Disetujui' => 'check-circle',

        'Ditolak' => 'x-circle',

        'Menunggu' => 'hourglass',

        default => 'circle',

    };
}

/*
|--------------------------------------------------------------------------
| Approval Time
|--------------------------------------------------------------------------
*/

public function getApprovalTimeAttribute(): ?string
{
    return $this->approved_at
        ? $this->approved_at->format('d M Y • H:i')
        : null;
}

/*
|--------------------------------------------------------------------------
| Nama Jabatan
|--------------------------------------------------------------------------
*/

public function getJabatanAttribute(): string
{
    return $this->workflow?->jabatan?->nama_jabatan
        ?? '-';
}

public function getStatusLabelAttribute(): string
{
    return match ($this->status) {

        'Disetujui' => 'Disetujui',

        'Ditolak' => 'Ditolak',

        'Menunggu' => 'Menunggu Persetujuan',

        default => $this->status,

    };
}

}