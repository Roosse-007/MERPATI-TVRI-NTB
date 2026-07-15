<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NomorSurat extends Model
{
    protected $table = 'nomor_surat';

    protected $fillable = [
        'jenis_surat_id',
        'kode_nomor',
        'nomor_terakhir',
        'tahun',
    ];

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class);
    }
}