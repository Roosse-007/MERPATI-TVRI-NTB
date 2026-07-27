<?php

namespace App\Http\Controllers;


use App\Models\Surat;
use App\Models\PengesahanSurat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;



class PengesahanController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | HALAMAN PILIH PENGESAHAN
    |--------------------------------------------------------------------------
    */

    public function create($id)
    {

        $surat = Surat::findOrFail($id);


        return view(
            'surat.pengesahan',
            compact('surat')
        );

    }





    /*
    |--------------------------------------------------------------------------
    | FORM UPLOAD TTE
    |--------------------------------------------------------------------------
    */

    public function formTTE($id)
    {

        $surat = Surat::findOrFail($id);


        return view(
            'surat.upload-tte',
            compact('surat')
        );

    }





    /*
    |--------------------------------------------------------------------------
    | FORM UPLOAD QR CODE
    |--------------------------------------------------------------------------
    */

    public function formQR($id)
    {

        $surat = Surat::findOrFail($id);


        return view(
            'surat.upload-qr',
            compact('surat')
        );

    }







    /*
    |--------------------------------------------------------------------------
    | SIMPAN FILE TTE / QR
    |--------------------------------------------------------------------------
    */

    public function uploadPengesahan(
        Request $request,
        $id
    )
    {


        $request->validate([

            'metode'
            =>
            'required|in:TTE,QR Code',


            'file'
            =>
            'required|file|max:2048'

        ]);




        $surat = Surat::findOrFail($id);





        /*
        |--------------------------------------------------------------------------
        | SIMPAN FILE
        |--------------------------------------------------------------------------
        */


        $path = $request
            ->file('file')
            ->store(
                'pengesahan',
                'public'
            );







        /*
        |--------------------------------------------------------------------------
        | DATA PENGESAHAN
        |--------------------------------------------------------------------------
        */


        $data = [


            'user_id'
            =>
            Auth::id(),


            'metode'
            =>
            $request->metode,


            'status'
            =>
            'Disahkan',


            'nomor_verifikasi'
            =>
            'MANUAL-'
            .now()->format('YmdHis')
            .'-'
            .Str::upper(
                Str::random(5)
            ),


            'tanggal_pengesahan'
            =>
            now(),


        ];







        if($request->metode == 'TTE')
        {

            $data['ttd_file'] = $path;


        }
        else
        {

            $data['qr_code'] = $path;


        }








        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATABASE
        |--------------------------------------------------------------------------
        */


        PengesahanSurat::updateOrCreate(

            [

                'surat_id'=>$surat->id

            ],


            $data

        );








        /*
        |--------------------------------------------------------------------------
        | UPDATE SURAT
        |--------------------------------------------------------------------------
        */


        $surat->update([

            'status'=>'Disahkan',

            'tanggal_selesai'=>now()

        ]);








        return redirect()

            ->route(
                'surat.detail',
                $surat->id
            )

            ->with(

                'success',

                'Pengesahan berhasil disimpan.'

            );

    }









    /*
    |--------------------------------------------------------------------------
    | PROSES OTOMATIS QR/TTE
    | NANTI UNTUK GENERATE WORD
    |--------------------------------------------------------------------------
    */


    public function prosesPengesahan(
        Request $request,
        $id
    )
    {


        $request->validate([

            'metode'
            =>
            'required|in:TTE,QR Code'

        ]);




        $surat = Surat::findOrFail($id);




        if(!Auth::check())
        {

            abort(403);

        }



        return back()

            ->with(
                'success',
                'Metode pengesahan dipilih.'
            );

    }



}