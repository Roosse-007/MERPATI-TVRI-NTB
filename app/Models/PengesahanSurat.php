<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengesahanSurat extends Model
{

    protected $table = 'pengesahan_surat';



    protected $fillable = [

        'surat_id',

        'user_id',

        'metode',

        'status',

        'nomor_verifikasi',

        'ttd_file',

        'qr_code',

        'tanggal_pengesahan',

        'catatan',

    ];




    protected function casts(): array
    {
        return [

            'tanggal_pengesahan' => 'datetime',

        ];
    }





    /*
    |--------------------------------------------------------------------------
    | RELASI KE SURAT
    |--------------------------------------------------------------------------
    */

    public function surat(): BelongsTo
    {

        return $this->belongsTo(
            Surat::class,
            'surat_id'
        );

    }





    /*
    |--------------------------------------------------------------------------
    | RELASI USER / PEJABAT PENGESAH
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {

        return $this->belongsTo(
            User::class,
            'user_id'
        );

    }


}