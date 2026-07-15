<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Arsip extends Model
{
    protected $table = 'arsip';

    protected $fillable = [
        'surat_id',
        'folder_nas',
        'lokasi_file',
        'diarsipkan_oleh',
        'tanggal_arsip',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_arsip' => 'datetime',
        ];
    }

    public function surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class);
    }

    public function pengarsip(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diarsipkan_oleh');
    }
}