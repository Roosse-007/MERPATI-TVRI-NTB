<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Surat;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SuratController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | DAFTAR SURAT API
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $surat = Surat::with([

            'pengirim',
            'jenisSurat',
            'sifatSurat',
            'prioritasSurat'

        ])

        ->latest()

        ->paginate(10);



        return response()->json($surat);

    }






    /*
    |--------------------------------------------------------------------------
    | FORM BUAT SURAT BARU
    |--------------------------------------------------------------------------
    */
public function create()
{

    $users = User::with('jabatan')
        ->get();


    $templates = TemplateSurat::where(
        'is_active',
        true
    )
    ->get();



    return view(
        'surat.baru',
        compact(
            'users',
            'templates'
        )
    );

}





    /*
    |--------------------------------------------------------------------------
    | SIMPAN SURAT / DRAFT
    |--------------------------------------------------------------------------
    */

public function store(Request $request)
{

    $request->validate([

        'template_surat_id'=>'required',

        'perihal'=>'required',

        'isi_surat'=>'required',

    ]);





    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA SURAT
    |--------------------------------------------------------------------------
    */


    $surat = Surat::create([


        'template_surat_id'=>$request->template_surat_id,


        'nomor_surat'=>$request->nomor_surat,


        'perihal'=>$request->perihal,


        'isi_surat'=>$request->isi_surat,


        'tanggal_surat'=>now(),


        'status'=>'Draft',


        'pengirim_id'=>auth()->id(),


    ]);







    /*
    |--------------------------------------------------------------------------
    | GENERATE FILE DOCX DARI TEMPLATE
    |--------------------------------------------------------------------------
    */


    app(
        \App\Services\SuratGeneratorService::class
    )
    ->generate($surat);







    return redirect()

        ->route(
            'surat.detail',
            $surat->id
        )

        ->with(
            'success',
            'Surat berhasil dibuat.'
        );


}



    /*
    |--------------------------------------------------------------------------
    | DAFTAR DRAFT
    |--------------------------------------------------------------------------
    */

    public function draft()
    {


        $draft = Surat::with([

            'jenisSurat',

            'prioritasSurat'

        ])


        ->where(

            'pengirim_id',

            Auth::id()

        )


        ->where(

            'status',

            'Draft'

        )


        ->latest()


        ->get();





        return view(

            'surat.draft',

            compact('draft')

        );


    }









    /*
    |--------------------------------------------------------------------------
    | EDIT DRAFT
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


            'file_surat'=>'nullable|mimes:pdf|max:10240'


        ]);





        $surat = Surat::findOrFail($id);





        $file = $surat->file_surat;





        if($request->hasFile('file_surat'))
        {


            $file = $request

            ->file('file_surat')

            ->store('surat','public');


        }






        $surat->update([


            'perihal'=>$request->perihal,


            'ringkasan'=>$request->ringkasan,


            'isi_surat'=>$request->isi_surat,


            'file_surat'=>$file


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


        $surat = Surat::findOrFail($id);



        $surat->delete();




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
*//*
|--------------------------------------------------------------------------
| KIRIM SURAT KE APPROVAL
|--------------------------------------------------------------------------
*/

public function submit($id)
{

    $surat = Surat::findOrFail($id);



    if($surat->status !== 'Draft')
    {

        return redirect()
            ->back()
            ->with(
                'error',
                'Surat sudah diproses.'
            );

    }



    // Update status surat

    $surat->update([

        'status'=>'Menunggu Approval',

        'tanggal_kirim'=>now()

    ]);





    // Buat approval pertama

    Approval::create([

        'surat_id'=>$surat->id,

        // Kepala TVRI Stasiun NTB
        'approver_id'=>2,

        'urutan'=>1,

        'status'=>'Menunggu',

        'catatan'=>null,

    ]);





    return redirect()

        ->route('surat.draft')

        ->with(

            'success',

            'Surat berhasil dikirim untuk approval.'

        );

}

    /*
    |--------------------------------------------------------------------------
    | KOTAK MASUK WEB
    |--------------------------------------------------------------------------
    */

    public function inboxWeb(Request $request)
    {


        $query = Surat::with([


            'pengirim.jabatan',


            'jenisSurat',


            'prioritasSurat'


        ])

        ->where('status','!=','Draft');







        if($request->filled('search'))
        {


            $keyword = $request->search;



            $query->where(function($q) use($keyword){


                $q->where(
                    'nomor_surat',
                    'like',
                    "%$keyword%"
                )


                ->orWhere(
                    'perihal',
                    'like',
                    "%$keyword%"
                );


            });


        }







        if($request->filled('status'))
        {

            $query->where(

                'status',

                $request->status

            );

        }







        $surat = $query

        ->latest()

        ->paginate(10)

        ->withQueryString();







        $totalSurat = Surat::where(

            'status',

            '!=',

            'Draft'

        )->count();




        $diproses = Surat::where(

            'status',

            'Menunggu Approval'

        )->count();




        $arsip = Surat::where(

            'is_archived',

            true

        )->count();





        $menungguApproval = Surat::where(

            'status',

            'like',

            'Menunggu%'

        )->count();







        return view(

            'surat.inbox',

            compact(

                'surat',

                'totalSurat',

                'diproses',

                'arsip',

                'menungguApproval'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | SURAT TERKIRIM
    |--------------------------------------------------------------------------
    */

    public function sent()
    {


        $surat = Surat::with([

            'jenisSurat',

            'pengirim'

        ])

        ->where(

            'pengirim_id',

            Auth::id()

        )

        ->latest()

        ->paginate(10);







        return response()->json([


            'success'=>true,


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


        $surat = Surat::findOrFail($id);




        $surat->update([


            'is_archived'=>true


        ]);





        return redirect()

        ->back()

        ->with(

            'success',

            'Surat berhasil diarsipkan.'

        );


    }









    /*
    |--------------------------------------------------------------------------
    | LIST ARSIP API
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


            'data'=>$surat


        ]);

    }









    /*
    |--------------------------------------------------------------------------
    | HALAMAN ARSIP WEB
    |--------------------------------------------------------------------------
    */

    public function archiveWeb()
    {


        $surat = Surat::with([

            'pengirim.jabatan',

            'jenisSurat',

            'tujuan.user'

        ])

        ->where(

            'is_archived',

            true

        )

        ->latest()

        ->paginate(10);







        return view(

            'surat.arsip',

            compact('surat')

        );


    }









    /*
    |--------------------------------------------------------------------------
    | DETAIL SURAT API
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {


        $surat = Surat::with([


            'pengirim.jabatan',


            'jenisSurat',


            'sifatSurat',


            'prioritasSurat',


           'approvals.approver.jabatan' 


        ])

        ->findOrFail($id);







        return response()->json([


            'success'=>true,


            'data'=>$surat


        ]);


    }









    /*
    |--------------------------------------------------------------------------
    | DETAIL SURAT WEB
    |--------------------------------------------------------------------------
    */public function showWeb($id)
{

    $surat = Surat::with([

        /*
        |--------------------------------------------------------------------------
        | INFORMASI SURAT
        |--------------------------------------------------------------------------
        */

        'pengirim.jabatan',

        'tujuan.user.jabatan',

        'jenisSurat',

        'sifatSurat',

        'prioritasSurat',



        /*
        |--------------------------------------------------------------------------
        | LAMPIRAN
        |--------------------------------------------------------------------------
        */

        'lampiran',



        /*
        |--------------------------------------------------------------------------
        | DISPOSISI
        |--------------------------------------------------------------------------
        */

        'disposisi.dariUser.jabatan',

        'disposisi.keUser.jabatan',



        /*
        |--------------------------------------------------------------------------
        | APPROVAL
        |--------------------------------------------------------------------------
        */

      'approvals.approver.jabatan',



        /*
        |--------------------------------------------------------------------------
        | ARSIP
        |--------------------------------------------------------------------------
        */

        'arsip'


    ])
    ->findOrFail($id);





    /*
    |--------------------------------------------------------------------------
    | USER UNTUK DISPOSISI
    |--------------------------------------------------------------------------
    |
    | Digunakan pada form:
    | "Pilih Penerima Disposisi"
    |
    */

    $users = User::with('jabatan')

        ->where('is_active', true)

        ->where('id','!=',auth()->id())

        ->orderBy('name')

        ->get();






    /*
    |--------------------------------------------------------------------------
    | AKTIVITAS SURAT
    |--------------------------------------------------------------------------
    |
    | Mengambil log aktivitas surat
    |
    */

    $aktivitas = ActivityLog::with('user')
    ->latest()
    ->limit(10)
    ->get();






    return view(

        'surat.detail',

        compact(

            'surat',

            'users',

            'aktivitas'

        )

    );

}

    /*
    |--------------------------------------------------------------------------
    | INBOX KTU
    |--------------------------------------------------------------------------
    */

    public function inboxKtu()
    {


        $surat = Surat::where(

            'status',

            'Menunggu Paraf KTU'

        )

        ->latest()

        ->paginate(10);






        return response()->json([

            'success'=>true,

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


        $surat = Surat::where(

            'status',

            'Menunggu Persetujuan Kepala Stasiun'

        )

        ->latest()

        ->paginate(10);






        return response()->json([

            'success'=>true,

            'data'=>$surat

        ]);


    }
public function approval()
{

    $surat = Surat::with([

        'pengirim',

        'jenisSurat',

        'approvals.approver.jabatan'

    ])

    ->where('status','Menunggu Approval')

    ->latest()

    ->paginate(10);



    $totalSurat = Surat::count();



    $menunggu = Surat::where(
        'status',
        'Menunggu Approval'
    )->count();



    $disetujui = Surat::where(
        'status',
        'Disetujui'
    )->count();



    $ditolak = Surat::where(
        'status',
        'Ditolak'
    )->count();



    return view(

        'surat.approval',

        compact(

            'surat',

            'totalSurat',

            'menunggu',

            'disetujui',

            'ditolak'

        )

    );

}
}