<?php

namespace App\Http\Controllers;


use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SuratTujuan;
use App\Models\JenisSurat;
use App\Models\SifatSurat;
use Illuminate\Support\Facades\Auth;


class SuratController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | DAFTAR SURAT API
    |--------------------------------------------------------------------------
    */

public function create()
{
    $users = User::with('jabatan')
        ->where('is_active',1)
        ->get();

    $jenisSurat = JenisSurat::where('is_active',1)
        ->orderBy('id')
        ->get();

    $sifatSurat = SifatSurat::orderBy('nama_sifat')
        ->get();

    return view(
        'surat.baru',
        compact(
            'users',
            'jenisSurat',
            'sifatSurat'
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
    'jenis_surat_id' => 'required|exists:jenis_surat,id',
    'sifat_surat_id' => 'required|exists:sifat_surat,id',
    'nomor_surat' => 'required|unique:surat,nomor_surat',
    'tanggal_surat' => 'required|date',
    'deadline' => 'nullable|date',
    'tujuan_id' => 'required|exists:users,id',
    'perihal' => 'required|max:255',
    'file_surat' => 'nullable|mimes:pdf,doc,docx|max:10240',
]);





        $file = null;



        if($request->hasFile('file_surat'))
        {


            $file = $request

            ->file('file_surat')

            ->store('surat','public');


        }


        $status = $request->action == 'kirim'
    ? 'Menunggu Approval KPP'
    : 'Draft';


        $surat = Surat::create([



            'jenis_surat_id' => $request->jenis_surat_id,
            'sifat_surat_id' => $request->sifat_surat_id,

            'prioritas_surat_id'=>2,


            'pengirim_id'=>Auth::id(),



            'nomor_surat' => $request->nomor_surat,

            'tanggal_surat' => $request->tanggal_surat,
            'deadline' => $request->deadline,

            'tanggal_kirim' => $status == 'Draft'
            ? null
            : now(),

            'status' => $status,



            'perihal'=>$request->perihal,


            'file_surat'=>$file,



            



            'is_archived'=>false



        ]);


        SuratTujuan::create([
            'surat_id' => $surat->id,
            'user_id'  => $request->tujuan_id,
            'dibaca'   => false,
        ]);




        if ($status == 'Draft') {

    return redirect()
        ->route('surat.draft')
        ->with('success','Draft berhasil disimpan.');

}

return redirect()
    ->route('surat.approval')
    ->with('success','Surat berhasil dikirim.');


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


        $surat->update([

        'perihal' => $request->perihal,

        'file_surat' => $file,

    ]);





        $surat = Surat::findOrFail($id);





        $file = $surat->file_surat;





        if($request->hasFile('file_surat'))
        {


            $file = $request

            ->file('file_surat')

            ->store('surat','public');


        }

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
        'status' => 'Menunggu Approval KPP',
        'tanggal_kirim' => now()
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
    ])->where('status', '!=', 'Draft');

    // SEARCH
    $search = trim($request->input('search', ''));

    if ($search !== '') {

        $query->where(function ($q) use ($search) {

            $q->where('nomor_surat', 'like', "%{$search}%")
              ->orWhere('perihal', 'like', "%{$search}%")
              ->orWhereHas('pengirim', function ($user) use ($search) {

                    $user->where('name', 'like', "%{$search}%");

              });

        });

    }

    // FILTER STATUS
    if ($request->filled('status')) {

        $query->where('status', $request->status);

    }

    $surat = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    $totalSurat = Surat::where('status', '!=', 'Draft')->count();

    $diproses = Surat::whereIn('status', [
    'Menunggu Approval KPP',
    'Menunggu Approval KTU',
    'Menunggu Approval Kepala Stasiun',
])->count();

    $arsip = Surat::where('is_archived', true)->count();

    $menungguApproval = Surat::where('status', 'like', 'Menunggu%')->count();

    return view('surat.inbox', compact(
        'surat',
        'totalSurat',
        'diproses',
        'arsip',
        'menungguApproval'
    ));
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

            'Menunggu Approval KTU'

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

            'Menunggu Approval Kepala Stasiun'

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
        'tujuan.user',
        'approval'
    ])
    ->latest()
    ->paginate(10);

    $totalSurat = Surat::count();

    $menunggu = Surat::whereIn('status', [
        'Menunggu Approval KPP',
        'Menunggu Approval KTU',
        'Menunggu Approval Kepala Stasiun'
    ])->count();

    $disetujui = Surat::where('status', 'Disetujui')->count();

    $ditolak = Surat::where('status', 'Ditolak')->count();

    return view('surat.approval', compact(
        'surat',
        'totalSurat',
        'menunggu',
        'disetujui',
        'ditolak'
    ));
}
}