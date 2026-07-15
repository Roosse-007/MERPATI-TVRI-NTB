<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TargetTim extends Model
{
    protected $table = 'target_tim';

    protected $fillable = [
        'unit_kerja_id',
        'bulan',
        'tahun',
        'target',
        'realisasi',
    ];

    public function unitKerja(): BelongsTo
    {
        return $this->belongsTo(UnitKerja::class);
    }
}