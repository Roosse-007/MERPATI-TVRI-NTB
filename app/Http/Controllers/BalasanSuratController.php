<?php

namespace App\Http\Controllers;


use App\Models\Surat;
use App\Models\SuratTujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class BalasanSuratController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | FORM BALAS SURAT
    |--------------------------------------------------------------------------
    */


    public function create($id)
    {


        $surat = Surat::findOrFail($id);



        return view(
            'surat.balas',
            compact('surat')
        );


    }







    /*
    |--------------------------------------------------------------------------
    | SIMPAN BALASAN
    |--------------------------------------------------------------------------
    */


    public function store(Request $request, $id)
    {


        $suratAsal = Surat::findOrFail($id);




        $request->validate([


            'tujuan_id'=>'required',


            'perihal'=>'required',


            'isi_surat'=>'required',


        ]);







        /*
        |--------------------------------------------------------------------------
        | BUAT SURAT BALASAN
        |--------------------------------------------------------------------------
        */


        $balasan = Surat::create([



            'parent_surat_id'
                =>
                $suratAsal->id,



            'jenis_surat_id'
                =>
                $suratAsal->jenis_surat_id,



            'sifat_surat_id'
                =>
                $suratAsal->sifat_surat_id,



            'prioritas_surat_id'
                =>
                $suratAsal->prioritas_surat_id,



            'pengirim_id'
                =>
                Auth::id(),





            'nomor_surat'
                =>
                'BALASAN/TVRI/NTB/'
                .now()->format('YmdHis'),





            'perihal'
                =>
                $request->perihal,




            'ringkasan'
                =>
                $request->ringkasan,




            'isi_surat'
                =>
                $request->isi_surat,





            'tanggal_surat'
                =>
                now(),




            'status'
                =>
                'Draft',



        ]);









        /*
        |--------------------------------------------------------------------------
        | SIMPAN TUJUAN SURAT BALASAN
        |--------------------------------------------------------------------------
        */


        SuratTujuan::create([


            'surat_id'
                =>
                $balasan->id,



            'user_id'
                =>
                $request->tujuan_id,


        ]);









        return redirect()

            ->route(
                'surat.detail',
                $balasan->id
            )

            ->with(
                'success',
                'Balasan surat berhasil dibuat'
            );


    }



}