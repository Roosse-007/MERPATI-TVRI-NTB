<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SifatSurat extends Model
{
    protected $table = 'sifat_surat';

    protected $fillable = [
        'nama_sifat',
    ];

    public function surat(): HasMany
    {
        return $this->hasMany(Surat::class);
    }
}