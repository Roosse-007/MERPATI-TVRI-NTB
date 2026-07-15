<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrioritasSurat extends Model
{
    protected $table = 'prioritas_surat';

    protected $fillable = [
        'nama_prioritas',
    ];

    public function surat(): HasMany
    {
        return $this->hasMany(Surat::class);
    }
}