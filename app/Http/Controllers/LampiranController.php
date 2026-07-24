<?php

namespace App\Http\Controllers;


use App\Models\Lampiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



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

                'max:51200', // maksimal 50 MB

                'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png'

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
        | SIMPAN FILE KE STORAGE
        |--------------------------------------------------------------------------
        */


        $path = $file->store(

            'lampiran',

            'public'

        );





        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA DATABASE
        |--------------------------------------------------------------------------
        */
Lampiran::create([


    'surat_id' => $request->surat_id,


    'nama_file' => $file->getClientOriginalName(),


    'path_file' => $path,


    'mime_type' => $file->getMimeType(),


    // simpan byte asli
    'ukuran_file' => $file->getSize(),


    'uploaded_by' => auth()->id()


]);






        return back()->with(

            'success',

            'Lampiran berhasil ditambahkan'

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


        if(Storage::disk('public')->exists($lampiran->path_file))
        {

            Storage::disk('public')
                ->delete($lampiran->path_file);

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