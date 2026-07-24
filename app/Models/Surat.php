<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;



class Surat extends Model
{
    use SoftDeletes;


    protected $table = 'surat';



    protected $fillable = [

    'parent_surat_id',

        'jenis_surat_id',

        'file_docx_path',

        'file_pdf_path',

        'sifat_surat_id',

        'prioritas_surat_id',

        'template_surat_id',

        'pengirim_id',

        'nomor_surat',

        'perihal',

        'ringkasan',

        'isi_surat',

        'tanggal_surat',

        'tanggal_kirim',

        'tanggal_selesai',

        'status',

        'catatan',
        
        'template_surat_id',

        'file_surat',

        'is_archived',

    ];




    protected function casts(): array
    {

        return [

            'tanggal_surat' => 'date',

            'tanggal_kirim' => 'datetime',

            'tanggal_selesai' => 'datetime',

            'is_archived' => 'boolean',

        ];

    }












    /*
    |--------------------------------------------------------------------------
    | PENGIRIM
    |--------------------------------------------------------------------------
    */

    public function pengirim(): BelongsTo
    {

        return $this->belongsTo(
            User::class,
            'pengirim_id'
        );

    }







    /*
    |--------------------------------------------------------------------------
    | MASTER SURAT
    |--------------------------------------------------------------------------
    */

    public function jenisSurat(): BelongsTo
    {

        return $this->belongsTo(
            JenisSurat::class
        );

    }



    public function sifatSurat(): BelongsTo
    {

        return $this->belongsTo(
            SifatSurat::class
        );

    }



    public function prioritasSurat(): BelongsTo
    {

        return $this->belongsTo(
            PrioritasSurat::class
        );

    }



    public function templateSurat(): BelongsTo
    {

        return $this->belongsTo(
            TemplateSurat::class
        );

    }








    /*
    |--------------------------------------------------------------------------
    | LAMPIRAN
    |--------------------------------------------------------------------------
    */

    public function lampiran(): HasMany
    {

        return $this->hasMany(
            Lampiran::class
        );

    }






/*
|--------------------------------------------------------------------------
| APPROVAL
|--------------------------------------------------------------------------
*/

public function approvals(): HasMany
{
    return $this->hasMany(
        Approval::class,
        'surat_id'
    );
}






    /*
    |--------------------------------------------------------------------------
    | DISPOSISI
    |--------------------------------------------------------------------------
    */

    public function disposisi(): HasMany
    {

        return $this->hasMany(
            Disposisi::class
        );

    }







    /*
    |--------------------------------------------------------------------------
    | TUJUAN SURAT
    |--------------------------------------------------------------------------
    */

    public function tujuan(): HasMany
    {

        return $this->hasMany(
            SuratTujuan::class
        );

    }





/*
|--------------------------------------------------------------------------
| PENGESAHAN SURAT
|--------------------------------------------------------------------------
*/

public function pengesahan(): HasOne
{
    return $this->hasOne(
        PengesahanSurat::class,
        'surat_id'
    );
}

/*
|--------------------------------------------------------------------------
| BALASAN SURAT
|--------------------------------------------------------------------------
*/


public function suratInduk()
{
    return $this->belongsTo(
        Surat::class,
        'parent_surat_id'
    );
}



public function balasan()
{
    return $this->hasMany(
        Surat::class,
        'parent_surat_id'
    );
}

    /*
    |--------------------------------------------------------------------------
    | ARSIP
    |--------------------------------------------------------------------------
    */

    public function arsip(): HasOne
    {

        return $this->hasOne(
            Arsip::class
        );

    }


}