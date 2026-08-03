<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{

    protected $table = 'lampiran';


    protected $fillable = [
        'surat_id',
        'nama_file',
        'path_file',
        'mime_type',
        'ukuran_file',
        'uploaded_by',
    ];



    /*
    |--------------------------------------------------------------------------
    | RELASI KE SURAT
    |--------------------------------------------------------------------------
    */

    public function surat()
    {
        return $this->belongsTo(
            Surat::class,
            'surat_id'
        );
    }




    /*
    |--------------------------------------------------------------------------
    | RELASI USER PENGUPLOAD
    |--------------------------------------------------------------------------
    */

    public function uploadedBy()
    {
        return $this->belongsTo(
            User::class,
            'uploaded_by'
        );
    }


}