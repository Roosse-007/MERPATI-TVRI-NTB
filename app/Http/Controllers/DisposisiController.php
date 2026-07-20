<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisposisiController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | API SEMUA DISPOSISI
    |--------------------------------------------------------------------------
    */

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

            'success'=>true,

            'data'=>$disposisi

        ]);

    }





    /*
    |--------------------------------------------------------------------------
    | HALAMAN DETAIL BUAT DISPOSISI
    |--------------------------------------------------------------------------
    */

    public function showWeb($id)
    {

        $surat = Surat::with([

            'pengirim.jabatan',
            'prioritasSurat',
            'jenisSurat',
            'sifatSurat',
            'disposisi.dariUser.jabatan',
            'disposisi.keUser.jabatan'

        ])
        ->findOrFail($id);



        $users = User::with('jabatan')
            ->orderBy('name')
            ->get();



        return view(
            'surat.disposisi',
            compact(
                'surat',
                'users'
            )
        );

    }





    /*
    |--------------------------------------------------------------------------
    | SIMPAN DISPOSISI API
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

        $request->validate([

            'surat_id'=>'required|exists:surat,id',

            'ke_user_id'=>'required|exists:users,id',

            'instruksi'=>'required|string|max:1000',

        ]);



        $disposisi = Disposisi::create([

            'surat_id'=>$request->surat_id,

            'dari_user_id'=>Auth::id(),

            'ke_user_id'=>$request->ke_user_id,

            'instruksi'=>$request->instruksi,

            'status'=>'Aktif',

        ]);



        return response()->json([

            'success'=>true,

            'message'=>'Disposisi berhasil dibuat',

            'data'=>$disposisi

        ],201);

    }





    /*
    |--------------------------------------------------------------------------
    | INBOX DISPOSISI USER
    |--------------------------------------------------------------------------
    */

    public function inbox($userId)
    {


        $disposisi = Disposisi::with([

            'surat.prioritasSurat',

            'dariUser.jabatan',

            'keUser.jabatan'

        ])
        ->where('ke_user_id',$userId)
        ->latest()
        ->paginate(10);



        return response()->json([

            'success'=>true,

            'message'=>'Inbox Disposisi',

            'data'=>$disposisi

        ]);

    }






    /*
    |--------------------------------------------------------------------------
    | DETAIL DISPOSISI API
    |--------------------------------------------------------------------------
    */

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





    /*
    |--------------------------------------------------------------------------
    | TANDAI DIBACA
    |--------------------------------------------------------------------------
    */

    public function read($id)
    {

        $disposisi = Disposisi::find($id);



        if(!$disposisi){

            return response()->json([

                'success'=>false,

                'message'=>'Disposisi tidak ditemukan'

            ],404);

        }



        $disposisi->update([

            'dibaca'=>true,

            'dibaca_at'=>now()

        ]);



        return response()->json([

            'success'=>true,

            'message'=>'Disposisi dibaca'

        ]);

    }






    /*
    |--------------------------------------------------------------------------
    | SELESAIKAN DISPOSISI
    |--------------------------------------------------------------------------
    */

    public function finish($id)
    {

        $disposisi = Disposisi::find($id);



        if(!$disposisi){

            return response()->json([

                'success'=>false,

                'message'=>'Disposisi tidak ditemukan'

            ],404);

        }



        $disposisi->update([

            'status'=>'Selesai'

        ]);



        return response()->json([

            'success'=>true,

            'message'=>'Disposisi selesai',

            'data'=>$disposisi

        ]);

    }







    /*
    |--------------------------------------------------------------------------
    | SIMPAN DISPOSISI DARI WEB
    |--------------------------------------------------------------------------
    */

    public function storeWeb(Request $request)
    {


        $request->validate([

            'surat_id'=>'required|exists:surat,id',

            'ke_user_id'=>'required|exists:users,id',

            'instruksi'=>'required|string|max:1000',

        ]);




        Disposisi::create([


            'surat_id'=>$request->surat_id,


            'dari_user_id'=>Auth::id(),


            'ke_user_id'=>$request->ke_user_id,


            'instruksi'=>$request->instruksi,


            'status'=>'Aktif',


        ]);





        return redirect()

            ->route('disposisi.index')

            ->with(

                'success',

                'Disposisi berhasil dibuat.'

            );

    }







    /*
    |--------------------------------------------------------------------------
    | HALAMAN LIST DISPOSISI WEB
    |--------------------------------------------------------------------------
    */

    public function indexWeb()
    {


        $disposisi = Disposisi::with([

            'surat',

            'dariUser.jabatan',

            'keUser.jabatan'

        ])
        ->latest()
        ->paginate(10);




        return view(

            'surat.disposisi-index',

            compact('disposisi')

        );


    }


}