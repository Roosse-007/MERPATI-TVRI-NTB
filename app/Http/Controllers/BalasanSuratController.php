<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratTujuan;
use App\Models\Lampiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class BalasanSuratController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | FORM BALAS SURAT
    |--------------------------------------------------------------------------
    */

    public function create($id)
    {
        $surat = Surat::with('pengirim')
            ->findOrFail($id);


        return view(
            'surat.balas',
            compact('surat')
        );
    }



    /*
    |--------------------------------------------------------------------------
    | DETAIL SURAT + RIWAYAT BALASAN
    |--------------------------------------------------------------------------
        */
    public function detail($id)
    {

        $surat = Surat::with([

            'pengirim',
            'tujuan.user',
            'suratInduk'

        ])->findOrFail($id);



        // ambil surat induk utama
        $rootId = $surat->parent_surat_id ?? $surat->id;



        // semua balasan dalam 1 thread
        $riwayatBalasan = Surat::where(
    'parent_surat_id',
    $rootId
)
->with([
    'pengirim',
    'tujuan.user',
    'lampiran'
])
->orderBy(
    'created_at',
    'desc'
)
->get();



        return view(
            'surat.detail',
            compact(
                'surat',
                'riwayatBalasan'
            )
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


            'tujuan_id' => [
                'required',
                'exists:users,id'
            ],



            'perihal' => [
                'required',
                'max:255'
            ],



            'catatan' => [
                'required',
                'string'
            ],



            'lampiran' => [
                'nullable',
                'file',
                'max:102400',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip,rar'
            ]


        ]);





        DB::transaction(function () use (
            $request,
            $suratAsal
        ) {



            /*
            |--------------------------------------------------------------------------
            | TENTUKAN SURAT INDUK
            |--------------------------------------------------------------------------
            */

            $parentId = $suratAsal->parent_surat_id
                ?? $suratAsal->id;





            /*
            |--------------------------------------------------------------------------
            | BUAT SURAT BALASAN
            |--------------------------------------------------------------------------
            */

            $balasan = Surat::create([


                'parent_surat_id' => $parentId,


                'jenis_surat_id' => 
                    $suratAsal->jenis_surat_id,


                'sifat_surat_id' => 
                    $suratAsal->sifat_surat_id,


                'pengirim_id' => 
                    Auth::id(),



                'nomor_surat' => 
                    'BALASAN/TVRI/NTB/'
                    . now()->format('YmdHis'),



                'perihal' => 
                    $request->perihal,



                'catatan' =>
                    $request->catatan,



                'tanggal_surat' =>
                    now(),



                'tanggal_kirim' =>
                    now(),



                'status' =>
                    'Terkirim',



            ]);








            /*
            |--------------------------------------------------------------------------
            | SIMPAN TUJUAN BALASAN
            |--------------------------------------------------------------------------
            */
// Tujuan asli balasan
SuratTujuan::create([

    'surat_id' => $balasan->id,

    'user_id' => $request->tujuan_id,

    'dibaca' => false,

]);


// Pengirim balasan juga dapat melihat balasan
SuratTujuan::firstOrCreate(

    [
        'surat_id' => $balasan->id,
        'user_id'  => $request->tujuan_id,
    ],

    [
        'dibaca' => false,
    ]

);







            /*
            |--------------------------------------------------------------------------
            | SIMPAN LAMPIRAN BALASAN
            |--------------------------------------------------------------------------
            */


            if($request->hasFile('lampiran')){


                $file = $request->file('lampiran');



                $path = $file->store(
                    'lampiran',
                    'public'
                );




                Lampiran::create([


                    'surat_id' =>
                        $balasan->id,



                    'nama_file' =>
                        $file->getClientOriginalName(),



                    'path_file' =>
                        $path,



                    'mime_type' =>
                        $file->getMimeType(),



                    'ukuran_file' =>
                        $file->getSize(),



                    'uploaded_by' =>
                        Auth::id(),


                ]);

            }



        });







        return redirect()

            ->route(
                'surat.detail',
                $suratAsal->parent_surat_id ?? $suratAsal->id
            )

            ->with(
                'success',
                'Balasan surat berhasil dikirim'
            );


    }

}