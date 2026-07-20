<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSuratRequest;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SuratController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | DAFTAR SEMUA SURAT
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $surat = Surat::with([
            'pengirim',
            'jenisSurat',
            'sifatSurat',
            'prioritasSurat',
            'templateSurat'
        ])
        ->latest()
        ->paginate(10);


        return response()->json($surat);

    }





    /*
    |--------------------------------------------------------------------------
    | HALAMAN DRAFT
    |--------------------------------------------------------------------------
    */


    public function draft()
    {

        $user = Auth::user();


        $draft = Surat::with([
            'jenisSurat',
            'prioritasSurat'
        ])
        ->where('pengirim_id',$user->id)
        ->where('status','Draft')
        ->latest()
        ->get();



        return view(
            'surat.draft',
            compact('draft')
        );

    }





    /*
    |--------------------------------------------------------------------------
    | API DRAFT
    |--------------------------------------------------------------------------
    */


    public function draftApi()
    {


        $draft = Surat::with([
            'pengirim',
            'jenisSurat',
            'prioritasSurat'
        ])
        ->where('status','Draft')
        ->latest()
        ->paginate(10);



        return response()->json([

            'success'=>true,

            'message'=>'Daftar Draft Surat',

            'data'=>$draft

        ]);

    }







    /*
    |--------------------------------------------------------------------------
    | FORM BUAT DRAFT
    |--------------------------------------------------------------------------
    */
public function create()
{

    $users = User::with('jabatan')
        ->where('is_active',1)
        ->get();


    return view('surat.baru', compact('users'));

}





   /*
|--------------------------------------------------------------------------
| SIMPAN SURAT BARU / DRAFT
|--------------------------------------------------------------------------
*/

public function store(Request $request)
{

    $request->validate([

        'perihal'=>'required',

        'isi_surat'=>'required',

        'file_surat'=>'nullable|mimes:pdf|max:10240',

    ]);



    /*
    |--------------------------------------------------------------------------
    | UPLOAD FILE
    |--------------------------------------------------------------------------
    */


    $file = null;


    if($request->hasFile('file_surat'))
    {

        $file = $request
            ->file('file_surat')
            ->store('surat','public');

    }





    /*
    |--------------------------------------------------------------------------
    | SIMPAN SURAT
    |--------------------------------------------------------------------------
    */


    Surat::create([


        'jenis_surat_id'=>3,


        'sifat_surat_id'=>1,


        'prioritas_surat_id'=>2,


        'pengirim_id'=>auth()->id(),


        'nomor_surat'=>'DRAFT-TVRI-'
            .date('Y')
            .'-'
            .rand(1000,9999),



        'tanggal_surat'=>now(),



        'perihal'=>$request->perihal,



        'ringkasan'=>$request->ringkasan,



        'isi_surat'=>$request->isi_surat,



        'file_surat'=>$file,



        'status'=>'Draft',



        'is_archived'=>false,


    ]);




    return redirect()

        ->route('surat.draft')

        ->with(

            'success',

            'Draft surat berhasil dibuat.'

        );

}

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT DRAFT
    |--------------------------------------------------------------------------
    */
public function edit($id)
{

    $draft = Surat::with('tujuan')
        ->findOrFail($id);



    $users = User::with('jabatan')
        ->where('is_active',1)
        ->get();



    return view(

        'surat.edit',

        compact(

            'draft',

            'users'

        )

    );

}
   /*
|--------------------------------------------------------------------------
| UPDATE DRAFT
|--------------------------------------------------------------------------
*/

public function update(Request $request,$id)
{

    $request->validate([

        'perihal'=>'required',

        'isi_surat'=>'required',

        'file_surat'=>'nullable|mimes:pdf|max:10240',

    ]);



    $surat = Surat::findOrFail($id);



    /*
    |--------------------------------------------------------------------------
    | FILE LAMA
    |--------------------------------------------------------------------------
    */

    $file = $surat->file_surat;




    /*
    |--------------------------------------------------------------------------
    | JIKA ADA FILE BARU
    |--------------------------------------------------------------------------
    */

    if($request->hasFile('file_surat'))
    {

        $file = $request
            ->file('file_surat')
            ->store('surat','public');

    }




    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA
    |--------------------------------------------------------------------------
    */

    $surat->update([


        'perihal'=>$request->perihal,


        'ringkasan'=>$request->ringkasan,


        'isi_surat'=>$request->isi_surat,


        'file_surat'=>$file,


    ]);





    return redirect()

        ->route('surat.draft')

        ->with(

            'success',

            'Draft berhasil diperbarui.'

        );

}
    /*
    |--------------------------------------------------------------------------
    | HAPUS DRAFT
    |--------------------------------------------------------------------------
    */


    public function destroy($id)
    {


        $draft = Surat::findOrFail($id);



        $draft->delete();




        return redirect()

            ->route('surat.draft')

            ->with(

                'success',

                'Draft berhasil dihapus.'

            );


    }






/*
|--------------------------------------------------------------------------
| KIRIM SURAT KE APPROVAL
|--------------------------------------------------------------------------
*/


public function submit($id)
{

    $surat = Surat::find($id);



    if(!$surat)
    {

        return redirect()
        ->back()
        ->with(
            'error',
            'Surat tidak ditemukan.'
        );

    }




    // hanya draft yang boleh dikirim

    if($surat->status !== 'Draft')
    {

        return redirect()
        ->back()
        ->with(
            'error',
            'Surat sudah diproses.'
        );

    }




    $surat->update([


        'status'=>'Menunggu Approval',


        'tanggal_kirim'=>now()


    ]);





    return redirect()

    ->route('surat.draft')

    ->with(

        'success',

        'Surat berhasil dikirim dan menunggu approval.'

    );


}
        /*
    |--------------------------------------------------------------------------
    | INBOX SEMUA SURAT
    |--------------------------------------------------------------------------
    */


    public function inbox()
    {


        $surat = Surat::with([

            'pengirim.jabatan',

            'jenisSurat',

            'prioritasSurat'


        ])
        ->where('status','!=','Draft')

        ->latest()

        ->paginate(10);





        return response()->json([


            'success'=>true,


            'message'=>'Daftar Surat Masuk',


            'data'=>$surat


        ]);
        
    

    }









    /*
    |--------------------------------------------------------------------------
    | INBOX WEB
    |--------------------------------------------------------------------------
    */


    public function inboxWeb()
    {


        $surat = Surat::with([

            'pengirim.jabatan',

            'jenisSurat',

            'prioritasSurat'


        ])

        ->where('status','!=','Draft')

        ->latest()

        ->paginate(10);




        return view(

            'surat.inbox',

            compact('surat')

        );


    }









    /*
    |--------------------------------------------------------------------------
    | INBOX KTU
    |--------------------------------------------------------------------------
    */


    public function inboxKtu()
    {


        $surat = Surat::with([

            'pengirim',

            'jenisSurat',

            'prioritasSurat'

        ])

        ->where(
            'status',
            'Menunggu Paraf KTU'
        )

        ->latest()

        ->paginate(10);




        return response()->json([


            'success'=>true,


            'message'=>'Kotak Masuk KTU',


            'data'=>$surat


        ]);


    }









    /*
    |--------------------------------------------------------------------------
    | INBOX KEPALA STASIUN
    |--------------------------------------------------------------------------
    */


    public function inboxKepalaStasiun()
    {


        $surat = Surat::with([

            'pengirim',

            'jenisSurat',

            'prioritasSurat'

        ])

        ->where(
            'status',
            'Menunggu Persetujuan Kepala Stasiun'
        )

        ->latest()

        ->paginate(10);




        return response()->json([


            'success'=>true,


            'message'=>'Kotak Masuk Kepala Stasiun',


            'data'=>$surat


        ]);


    }









    /*
    |--------------------------------------------------------------------------
    | SURAT TERKIRIM
    |--------------------------------------------------------------------------
    */


    public function sent()
    {


        $surat = Surat::with([

            'pengirim.jabatan',

            'jenisSurat'


        ])

        ->where(
            'pengirim_id',
            Auth::id()
        )

        ->latest()

        ->paginate(10);




        return response()->json([


            'success'=>true,


            'message'=>'Daftar Surat Terkirim',


            'data'=>$surat


        ]);


    }









    /*
    |--------------------------------------------------------------------------
    | ARSIPKAN SURAT
    |--------------------------------------------------------------------------
    */


    public function archive($id)
    {


        $surat = Surat::find($id);



        if(!$surat)
        {


            return response()->json([


                'success'=>false,


                'message'=>'Surat tidak ditemukan.'


            ],404);


        }






        if($surat->status !== 'Disetujui')
        {


            return response()->json([


                'success'=>false,


                'message'=>'Surat belum dapat diarsipkan.'


            ],400);


        }






        $surat->update([


            'is_archived'=>true


        ]);






        return response()->json([


            'success'=>true,


            'message'=>'Surat berhasil diarsipkan.',


            'data'=>$surat


        ]);


    }









    /*
    |--------------------------------------------------------------------------
    | LIST ARSIP
    |--------------------------------------------------------------------------
    */


    public function archiveList()
    {


        $surat = Surat::with([

            'pengirim.jabatan',

            'jenisSurat'

        ])

        ->where(
            'is_archived',
            true
        )

        ->latest()

        ->paginate(10);






        return response()->json([


            'success'=>true,


            'message'=>'Daftar Surat Arsip',


            'data'=>$surat


        ]);


    }



/*
|--------------------------------------------------------------------------
| DETAIL SURAT WEB
|--------------------------------------------------------------------------
*/

public function showWeb($id)
{

    $surat = Surat::with([

        'pengirim.jabatan',

        'tujuan.user',

        'jenisSurat',

        'sifatSurat',

        'prioritasSurat',

        'templateSurat',

        'approval.approver.jabatan',

        'disposisi.dariUser.jabatan',

        'disposisi.keUser.jabatan'

    ])
    ->findOrFail($id);



    return view(

        'surat.detail',

        compact('surat')

    );

}





/*
|--------------------------------------------------------------------------
| ARSIP WEB
|--------------------------------------------------------------------------
*/

public function archiveWeb()
{

    $surat = Surat::with([

        'pengirim.jabatan',

        'jenisSurat',

        'tujuan.user'

    ])

    ->where('is_archived', true)

    ->latest()

    ->paginate(10);



    return view(

        'surat.arsip',

        compact('surat')

    );

}





    /*
    |--------------------------------------------------------------------------
    | DETAIL SURAT
    |--------------------------------------------------------------------------
    */


    public function show($id)
    {


        $surat = Surat::with([


            'pengirim.jabatan',


            'jenisSurat',


            'sifatSurat',


            'prioritasSurat',


            'templateSurat',


            'approval.approver.jabatan',


            'disposisi.dariUser.jabatan',


            'disposisi.keUser.jabatan'


        ])

        ->find($id);






        if(!$surat)
        {


            return response()->json([


                'success'=>false,


                'message'=>'Surat tidak ditemukan.'


            ],404);


        }






        return response()->json([


            'success'=>true,


            'message'=>'Detail Surat',


            'data'=>$surat


        ]);


    }



}
