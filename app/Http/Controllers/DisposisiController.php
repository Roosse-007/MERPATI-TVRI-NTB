<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use Illuminate\Http\Request;

class DisposisiController extends Controller
{

    // Semua disposisi
    public function index()
    {
        $disposisi = Disposisi::with([
            'surat',
            'dariUser.jabatan',
            'keUser.jabatan'
        ])
        ->latest()
        ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $disposisi
        ]);
    }


    // Membuat disposisi
    public function store(Request $request)
    {

        $request->validate([
            'surat_id' => 'required',
            'dari_user_id' => 'required',
            'ke_user_id' => 'required',
            'instruksi' => 'required',
        ]);


        $disposisi = Disposisi::create([

            'surat_id' => $request->surat_id,

            'dari_user_id' => $request->dari_user_id,

            'ke_user_id' => $request->ke_user_id,

            'instruksi' => $request->instruksi,

            'status' => 'Aktif'

        ]);


        return response()->json([
            'success' => true,
            'message' => 'Disposisi berhasil dibuat',
            'data' => $disposisi
        ],201);

    }



    // Inbox disposisi user tujuan
    public function inbox($userId)
    {

        $disposisi = Disposisi::with([
            'surat',
            'dariUser.jabatan'
        ])
        ->where('ke_user_id',$userId)
        ->latest()
        ->paginate(10);


        return response()->json([

    'success'=>true,

    'message'=>'Inbox Disposisi',

    'data'=>$disposisi->through(function($item){

        return [

            'id'=>$item->id,


            'surat'=>[

                'id'=>$item->surat->id ?? null,

                'nomor_surat'=>$item->surat->nomor_surat ?? null,

                'perihal'=>$item->surat->perihal ?? null,

                'status'=>$item->surat->status ?? null

            ],



            'dari'=>[

                'nama'=>$item->dariUser->name ?? null,

                'jabatan'=>$item->dariUser->jabatan->nama_jabatan ?? null

            ],



            'instruksi'=>$item->instruksi,


            'status'=>$item->status,


            'dibaca'=>$item->dibaca,


            'dibaca_at'=>$item->dibaca_at

        ];

    })

]);
    }



    // Detail disposisi
    public function show($id)
    {

        $disposisi = Disposisi::with([
            'surat',
            'dariUser.jabatan',
            'keUser.jabatan'
        ])
        ->find($id);


        if(!$disposisi){

            return response()->json([
                'success'=>false,
                'message'=>'Disposisi tidak ditemukan'
            ],404);

        }


        return response()->json([
            'success'=>true,
            'data'=>$disposisi
        ]);

    }



    // Tandai sudah dibaca
    public function read($id)
{

    $disposisi = Disposisi::find($id);


    if(!$disposisi){

        return response()->json([

            'success'=>false,

            'message'=>'Disposisi tidak ditemukan.'

        ],404);

    }



    $disposisi->update([

        'dibaca'=>true,

        'dibaca_at'=>now()

    ]);



    return response()->json([

        'success'=>true,

        'message'=>'Disposisi ditandai sudah dibaca.',

        'data'=>[

            'id'=>$disposisi->id,

            'dibaca'=>$disposisi->dibaca,

            'dibaca_at'=>$disposisi->dibaca_at

        ]

    ]);

}
    public function finish($id)
{
    $disposisi = Disposisi::find($id);

    if (!$disposisi) {
return response()->json([

    'success'=>true,

    'message'=>'Disposisi selesai.',

    'data'=>[

        'id'=>$disposisi->id,

        'status'=>$disposisi->status

    ]

]);
}
}
}