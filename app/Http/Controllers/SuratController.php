<?php

namespace App\Http\Controllers;


use App\Models\Surat;
use App\Models\User;
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

        ->where('is_active',1)

        ->get();



        return view(

            'surat.baru',

            compact('users')

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


            'perihal'=>'required',


            'isi_surat'=>'required',


            'file_surat'=>'nullable|mimes:pdf|max:10240'


        ]);





        $file = null;



        if($request->hasFile('file_surat'))
        {


            $file = $request

            ->file('file_surat')

            ->store('surat','public');


        }





        $surat = Surat::create([



            'jenis_surat_id'=>3,


            'sifat_surat_id'=>1,


            'prioritas_surat_id'=>2,


            'pengirim_id'=>Auth::id(),



            'nomor_surat'=>

                'DRAFT-TVRI-'

                .date('Y')

                .'-'

                .rand(1000,9999),



            'tanggal_surat'=>now(),



            'perihal'=>$request->perihal,



            'ringkasan'=>$request->ringkasan,



            'isi_surat'=>$request->isi_surat,



            'file_surat'=>$file,



            'status'=>'Draft',



            'is_archived'=>false



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


    }    /*
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




        $surat->update([


            'status'=>'Menunggu Approval',


            'tanggal_kirim'=>now()


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


            'approval.approver.jabatan'


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
    */

    public function showWeb($id)
    {


        $surat = Surat::with([


            'pengirim.jabatan',


            'tujuan.user',


            'jenisSurat',


            'approval.approver.jabatan'


        ])

        ->findOrFail($id);







        return view(

            'surat.detail',

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
        'approval'
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



    return view('surat.approval', compact(
        'surat',
        'totalSurat',
        'menunggu',
        'disetujui',
        'ditolak'
    ));

}
}