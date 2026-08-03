<?php

namespace App\Http\Controllers;

use App\Models\Lampiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


class LampiranController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | TAMBAH LAMPIRAN
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {


        $request->validate([


            'surat_id' => [
                'required',
                'exists:surat,id'
            ],


            'file' => [

                'required',

                'file',

                // maksimal 100 MB
                'max:102400'

            ]

        ]);





        /*
        |--------------------------------------------------------------------------
        | AMBIL FILE
        |--------------------------------------------------------------------------
        */


        $file = $request->file('file');





        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE STORAGE
        |--------------------------------------------------------------------------
        */


        $path = $file->store(
            'lampiran',
            'public'
        );






        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATABASE
        |--------------------------------------------------------------------------
        */


        Lampiran::create([


            'surat_id' => $request->surat_id,


            'nama_file' => 
                $file->getClientOriginalName(),



            'path_file' =>
                $path,



            'mime_type' =>
                $file->getMimeType(),



            'ukuran_file' =>
                $file->getSize(),



            'uploaded_by' =>
                auth()->id(),


        ]);






        return back()->with(

            'success',

            'Lampiran berhasil ditambahkan'

        );


    }








    /*
    |--------------------------------------------------------------------------
    | LIHAT / PREVIEW LAMPIRAN
    |--------------------------------------------------------------------------
    */

    public function view($id)
    {


        $lampiran = Lampiran::findOrFail($id);



        $path = storage_path(
            'app/public/'.$lampiran->path_file
        );



        if(!file_exists($path)){


            abort(
                404,
                'File tidak ditemukan'
            );


        }





        /*
        |--------------------------------------------------------------------------
        | FILE YANG BISA PREVIEW
        |--------------------------------------------------------------------------
        */


        if(

            str_starts_with(
                $lampiran->mime_type,
                'image/'
            )

            ||

            $lampiran->mime_type 
            == 
            'application/pdf'

        ){


            return response()->file($path);


        }







        /*
        |--------------------------------------------------------------------------
        | SELAIN ITU DOWNLOAD
        |--------------------------------------------------------------------------
        */


        return $this->download($id);



    }









    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD LAMPIRAN
    |--------------------------------------------------------------------------
    */

    public function download($id)
    {


        $lampiran = Lampiran::findOrFail($id);




        $path = storage_path(
            'app/public/'.$lampiran->path_file
        );




        if(!file_exists($path)){


            abort(
                404,
                'File tidak ditemukan'
            );


        }




        return Response::download(

            $path,

            $lampiran->nama_file

        );


    }









    /*
    |--------------------------------------------------------------------------
    | HAPUS LAMPIRAN
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {


        $lampiran = Lampiran::findOrFail($id);






        /*
        |--------------------------------------------------------------------------
        | HAPUS FILE FISIK
        |--------------------------------------------------------------------------
        */


        if(
            Storage::disk('public')
            ->exists($lampiran->path_file)
        )

        {


            Storage::disk('public')
            ->delete(
                $lampiran->path_file
            );


        }







        /*
        |--------------------------------------------------------------------------
        | HAPUS DATABASE
        |--------------------------------------------------------------------------
        */


        $lampiran->delete();







        return back()->with(

            'success',

            'Lampiran berhasil dihapus'

        );


    }



}