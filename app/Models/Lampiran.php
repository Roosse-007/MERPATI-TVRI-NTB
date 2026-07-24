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

        'uploaded_by'

    ];



    public function surat()
    {

        return $this->belongsTo(
            Surat::class,
            'surat_id'
        );

    }



    public function uploader()
    {

        return $this->belongsTo(
            User::class,
            'uploaded_by'
        );

    }


}