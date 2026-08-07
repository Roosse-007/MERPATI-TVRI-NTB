<?php

namespace App\Http\Controllers;


use App\Models\Approval;
use App\Models\Surat;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Disposisi;
use App\Models\SuratTujuan;
use App\Models\JenisSurat;
use App\Models\SifatSurat;
use App\Services\ApprovalWorkflowService;
use App\Models\TemplateSurat;
use App\Models\Lampiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



class SuratController extends Controller
{



    /*
    |--------------------------------------------------------------------------
    | DETAIL SURAT RIWAYAT BALASAN
    |--------------------------------------------------------------------------
    */
public function detail($id)
{

    $surat = Surat::with([

        'pengirim',

        'tujuan.user',

        'suratInduk',


        'balasan' => function($query){

            $query->with([

                'pengirim',

                'tujuan.user',

                'lampiran'

            ])
            ->orderBy('created_at','desc');

        }


    ])->findOrFail($id);





    // Ambil surat induk utama

    $rootId = $surat->parent_surat_id ?? $surat->id;





    // Ambil semua riwayat balasan
    // terbaru tampil paling atas

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
    | DAFTAR SURAT API
    |--------------------------------------------------------------------------
    */


    public function index()
    {


        $surat = Surat::with([

            'pengirim',

            'jenisSurat',

            'sifatSurat',

            //'prioritasSurat'

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





        $jenisSurat = JenisSurat::where(

            'is_active',

            1

        )

        ->orderBy('id')

        ->get();






        $sifatSurat = SifatSurat::orderBy(

            'nama_sifat'

        )

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

                'jenisSurat',

                'sifatSurat',

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
        'jenis_surat_id' => 'required|exists:jenis_surat,id',
        'sifat_surat_id' => 'required|exists:sifat_surat,id',
        'nomor_surat'    => 'required|unique:surat,nomor_surat',
        'tanggal_surat'  => 'required|date',
        'deadline'       => 'nullable|date',
        'tujuan_id'      => 'required|exists:users,id',
        'perihal'        => 'required|max:255',
        'file_surat'     => 'nullable|mimes:pdf,doc,docx|max:10240',
    ], [
        'nomor_surat.unique' => 'Nomor surat sudah digunakan, silakan gunakan nomor lain.',
    ]);

    $file = null;

    if ($request->hasFile('file_surat')) {
        $file = $request->file('file_surat')->store('surat', 'public');
    }

    $workflow = new ApprovalWorkflowService();

    $status = 'Draft';
    $tanggalKirim = null;

    if ($request->action === 'kirim') {
        $status = 'Menunggu Approval';
        $tanggalKirim = now();
    }

    DB::transaction(function () use (
        $request,
        $file,
        $status,
        $tanggalKirim,
        $workflow,
        &$surat
    ) {

        // Simpan surat
        $surat = Surat::create([
            'jenis_surat_id' => $request->jenis_surat_id,
            'sifat_surat_id' => $request->sifat_surat_id,
            'pengirim_id'    => Auth::id(),
            'nomor_surat'    => $request->nomor_surat,
            'tanggal_surat'  => $request->tanggal_surat,
            'tanggal_kirim'  => $tanggalKirim,
            'deadline'       => $request->deadline,
            'perihal'        => $request->perihal,
            'file_surat'     => $file,
            'status'         => $status,
            'is_archived'    => false,
        ]);

        // Simpan tujuan surat
        SuratTujuan::create([
            'surat_id' => $surat->id,
            'user_id'  => $request->tujuan_id,
            'dibaca'   => false,
        ]);

            if($request->hasFile('lampiran')) {


    $file = $request->file('lampiran');


    $path = $file->store(
        'lampiran',
        'public'
    );


    Lampiran::create([

        'surat_id'=>$surat->id,

        'nama_file'=>$file->getClientOriginalName(),

        'path_file'=>$path,

        'mime_type'=>$file->getMimeType(),

        'ukuran_file'=>$file->getSize(),

        'uploaded_by'=>auth()->id()

    ]);


}

        // Jika langsung dikirim, buat approval pertama
        if ($status !== 'Draft') {
            $workflow->createFirstApproval($surat);

        }

    });

    if ($status === 'Draft') {
        return redirect()
            ->route('surat.draft')
            ->with('success', 'Draft berhasil disimpan.');
    }

    return redirect()
    ->route('surat.terkirim')
    ->with('success','Surat berhasil dikirim.');
}
    /*
    |--------------------------------------------------------------------------
    | DAFTAR DRAFT
    |--------------------------------------------------------------------------
    */
public function draft(Request $request)
{

    $query = Surat::with([
        'jenisSurat',
        'sifatSurat',
        'tujuan.user',
        'pengirim'
    ])
    ->where('pengirim_id', Auth::id())
    ->where('status','Draft');



    // =====================
    // SEARCH
    // =====================

    if($request->filled('search')){


        $keyword = $request->search;


        $query->where(function($q) use ($keyword){


            $q->where(
                'nomor_surat',
                'like',
                "%{$keyword}%"
            )


            ->orWhere(
                'perihal',
                'like',
                "%{$keyword}%"
            )


            ->orWhereHas(
                'pengirim',
                function($user) use ($keyword){

                    $user->where(
                        'name',
                        'like',
                        "%{$keyword}%"
                    );

                }
            );


        });


    }





    // =====================
    // FILTER STATUS
    // =====================

    if($request->filled('status')){


        $query->where(
            'status',
            $request->status
        );


    }





    $draft = $query

        ->latest()

        ->paginate(10)

        ->withQueryString();




    return view(
        'surat.draft',
        compact('draft')
    );


}

// ===============================
// TAMBAHKAN FUNCTION PREVIEW DISINI
// ===============================


public function preview($id)
{

    $surat = Surat::findOrFail($id);


    if(!$surat->file_surat){

        abort(404);

    }


    $path = storage_path(
        'app/public/'.$surat->file_surat
    );


    if(!file_exists($path)){

        abort(404);

    }


    return response()->file($path);

}

public function edit($id)
    {


        $draft = Surat::with('tujuan')

            ->findOrFail($id);





        $users = User::with('jabatan')

            ->where('is_active',1)

            ->get();





        $templates = TemplateSurat::where(

            'is_active',

            true

        )

        ->get();







        return view(

            'surat.edit',

            compact(

                'draft',

                'users',

                'templates'

            )

        );


    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DRAFT
    |--------------------------------------------------------------------------
    */


    public function update(Request $request, $id)
{

    $surat = Surat::findOrFail($id);



    $request->validate([

        'perihal' => 'required',

        'lampiran' => 'nullable|file|max:10240'

    ]);



    $surat->update([

        'perihal' => $request->perihal

    ]);





    // Jika upload lampiran baru

    if($request->hasFile('lampiran'))
    {


        // hapus lampiran lama

        foreach($surat->lampiran as $lama)
        {


            Storage::disk('public')
                ->delete($lama->path_file);



            $lama->delete();


        }





        // simpan lampiran baru

        $file = $request->file('lampiran');


        $path = $file->store(

            'lampiran',

            'public'

        );





        Lampiran::create([


            'surat_id'=>$surat->id,


            'nama_file'=>$file->getClientOriginalName(),


            'path_file'=>$path,


            'mime_type'=>$file->getMimeType(),


            'ukuran_file'=>$file->getSize(),


            'uploaded_by'=>auth()->id()


        ]);



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
    | HAPUS SURAT
    |--------------------------------------------------------------------------
    */
public function destroy($id)
{
    $surat = Surat::findOrFail($id);

    if ($surat->status !== 'Draft') {
        return back()->with(
            'error',
            'Hanya surat draft yang dapat dihapus.'
        );
    }

    if ($surat->file_surat) {
        Storage::disk('public')->delete($surat->file_surat);
    }

    SuratTujuan::where('surat_id', $surat->id)->delete();
    Approval::where('surat_id', $surat->id)->delete();
    Disposisi::where('surat_id', $surat->id)->delete();

    $surat->delete();

    return redirect()
        ->route('surat.draft')
        ->with('success', 'Draft berhasil dihapus.');
}
/*
|--------------------------------------------------------------------------
| KIRIM SURAT KE APPROVAL
|--------------------------------------------------------------------------
*/

public function inboxWeb(Request $request)
{
    $user = Auth::user();

    $jabatan = $user->jabatan->nama_jabatan ?? '';

    $query = Surat::with([
        'pengirim.jabatan',
        'jenisSurat',
        'sifatSurat',
        'tujuan.user',
        'approval',
        'approval.approver',
    ])

    ->whereHas('tujuan', function ($q) use ($user) {

        $q->where('user_id', $user->id);

    })

    ->where(function($q){

        // surat asli
        $q->whereNull('parent_surat_id')


        // atau hanya balasan terbaru dari setiap thread
        ->orWhereIn('id', function($sub){

            $sub->selectRaw('MAX(id)')
                ->from('surat')
                ->whereNotNull('parent_surat_id')
                ->groupBy('parent_surat_id');

        });

    });


    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    if ($request->filled('search')) {

        $keyword = $request->search;

        $query->where(function ($q) use ($keyword) {

            $q->where('nomor_surat', 'like', "%{$keyword}%")

              ->orWhere('perihal', 'like', "%{$keyword}%")

              ->orWhereHas('pengirim', function ($pengirim) use ($keyword) {

                    $pengirim->where('name', 'like', "%{$keyword}%");

              });

        });

    }
    /*
    |--------------------------------------------------------------------------
    | FILTER STATUS
    |--------------------------------------------------------------------------
    */

    if ($request->filled('status')) {

        switch ($request->status) {

            case 'Menunggu':
                $query->whereHas('approval', function ($q) {

                    $q->where('approver_id', Auth::id())
                      ->where('status', 'Menunggu');

                });
                break;

            case 'Disetujui':
                $query->where('status', 'Disetujui');
                break;

            case 'Ditolak':
                $query->where('status', 'Ditolak');
                break;

            default:
                break;
        }

    }

    /*
    |--------------------------------------------------------------------------
    | DATA SURAT
    |--------------------------------------------------------------------------
    */

    $surat = (clone $query)
        ->latest()
        ->paginate(10)
        ->withQueryString();

    /*
    |--------------------------------------------------------------------------
    | CARD
    |--------------------------------------------------------------------------
    */

    $totalSurat = (clone $query)->count();

    $menungguApproval = (clone $query)
        ->whereHas('approval', function ($q) {

            $q->where('approver_id', Auth::id())
              ->where('status', 'Menunggu');

        })
        ->count();

    $diterima = (clone $query)
        ->where('status', 'Disetujui')
        ->count();

    $ditolak = (clone $query)
        ->where('status', 'Ditolak')
        ->count();

    return view('surat.inbox', compact(
        'surat',
        'totalSurat',
        'menungguApproval',
        'diterima',
        'ditolak'
    ));
}
public function submit($id)
{
    $surat = Surat::findOrFail($id);

    if ($surat->status !== 'Draft') {
        return back()->with(
            'error',
            'Surat sudah diproses.'
        );
    }

    $workflow = new ApprovalWorkflowService();

    $surat->update([
        'status' => 'Menunggu Approval',
        'tanggal_kirim' => now(),
    ]);

    $workflow->createFirstApproval($surat);

    return redirect()
        ->route('surat.approval')
        ->with('success', 'Surat berhasil dikirim untuk approval.');
}

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





        return back()->with(

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


        $surat = Surat::where(

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


            'pengirim',


            'jenisSurat'


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
    | DETAIL API
    |--------------------------------------------------------------------------
    */


    public function show($id)
    {


        $surat = Surat::with([


            'pengirim',


            'tujuan.user',


            'lampiran',


            'disposisi',


            'approval',


            'pengesahan',


            'balasan'


        ])

        ->findOrFail($id);







        return response()->json([


            'success'=>true,


            'data'=>$surat



        ]);



    }








/*
|--------------------------------------------------------------------------
| DETAIL WEB
|--------------------------------------------------------------------------
*/

public function showWeb($id)
{

    $surat = Surat::with([

        'pengirim.jabatan',

        'tujuan.user.jabatan',

        'jenisSurat',

        'sifatSurat',

        'lampiran',

        'disposisi.keUser.jabatan',

        'approval.approver',

        'suratInduk.balasan',

        'balasan'

    ])->findOrFail($id);



    $users = User::with('jabatan')
        ->where('is_active', 1)
        ->where('id', '!=', Auth::id())
        ->get();
    $aktivitas = collect();

    /*
    |--------------------------------------------------------------------------
    | AKTIVITAS SURAT
    |--------------------------------------------------------------------------
    */

    $aktivitas->push([
        'judul'      => 'Surat dibuat',
        'deskripsi'  => $surat->perihal,
        'waktu'      => $surat->created_at,
    ]);

    foreach ($surat->approval as $item) {
        $aktivitas->push([
            'judul'      => 'Approval Surat',
            'deskripsi'  => $item->status,
            'waktu'      => $item->created_at,
        ]);
    }

    foreach ($surat->disposisi as $item) {
        $aktivitas->push([
            'judul'      => 'Disposisi Surat',
            'deskripsi'  => $item->instruksi,
            'waktu'      => $item->created_at,
        ]);
    }

    $aktivitas = $aktivitas->sortByDesc('waktu');
    $riwayatBalasan = collect();


if($surat->parent_surat_id){

    $suratInduk = $surat->suratInduk;

    $riwayatBalasan = $suratInduk->balasan()
        ->orderBy('created_at','desc')
        ->get();

}else{

    $riwayatBalasan = $surat->balasan()
        ->orderBy('created_at','desc')
        ->get();

}

    return view('surat.detail', compact(
    'surat',
    'users',
    'aktivitas',
    'riwayatBalasan'
));
}
    /*
    |--------------------------------------------------------------------------
    | HALAMAN APPROVAL
    |--------------------------------------------------------------------------
    */

public function approval(Request $request)
{
    $query = Surat::with([
        'pengirim.jabatan',
        'tujuan.user',
        'approval.approver',
        'jenisSurat',
        'sifatSurat',
    ]);

    /*
    |--------------------------------------------------------------------------
    | SURAT YANG MENUNGGU APPROVAL USER LOGIN
    |--------------------------------------------------------------------------
    */

    if (!Auth::user()->hasRole('Admin')) {

        $query->whereHas('approval', function ($q) {
            $q->where('approver_id', auth()->id())
            ->where('status', 'Menunggu');
        });

    }

    /*
    |--------------------------------------------------------------------------
    | PENCARIAN
    |--------------------------------------------------------------------------
    */

    if ($request->filled('search')) {

        $keyword = $request->search;

        $query->where(function ($q) use ($keyword) {

            $q->where('nomor_surat', 'like', "%{$keyword}%")
              ->orWhere('perihal', 'like', "%{$keyword}%")
              ->orWhereHas('pengirim', function ($u) use ($keyword) {

                    $u->where('name', 'like', "%{$keyword}%");

              });

        });

    }

    /*
    |--------------------------------------------------------------------------
    | FILTER STATUS
    |--------------------------------------------------------------------------
    */

    if ($request->filled('status')) {

        $query->where('status', $request->status);

    }

    /*
    |--------------------------------------------------------------------------
    | FILTER JENIS SURAT
    |--------------------------------------------------------------------------
    */

    if ($request->filled('jenis_surat')) {

        $query->where('jenis_surat_id', $request->jenis_surat);

    }

    /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL
    |--------------------------------------------------------------------------
    */

    if ($request->filled('tanggal_awal')) {

        $query->whereDate(
            'tanggal_surat',
            '>=',
            $request->tanggal_awal
        );

    }

    if ($request->filled('tanggal_akhir')) {

        $query->whereDate(
            'tanggal_surat',
            '<=',
            $request->tanggal_akhir
        );

    }

    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    $surat = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

/*
|--------------------------------------------------------------------------
| STATISTIK
|--------------------------------------------------------------------------
*/

$approvalQuery = Approval::where('approver_id', Auth::id());

$totalSurat = (clone $approvalQuery)->count();

$menunggu = (clone $approvalQuery)
    ->where('status', 'Menunggu')
    ->count();

$disetujui = (clone $approvalQuery)
    ->where('status', 'Disetujui')
    ->count();

$ditolak = (clone $approvalQuery)
    ->where('status', 'Ditolak')
    ->count();
    

    return view('surat.approval', compact(
        'surat',
        'totalSurat',
        'menunggu',
        'disetujui',
        'ditolak'
    ));
}
        /*
    |--------------------------------------------------------------------------
    | INBOX KPP
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | INBOX KTU
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | INBOX KEPALA STASIUN
    |--------------------------------------------------------------------------
    */



public function filterInbox(Request $request)
{
    $query = Surat::with([
        'pengirim',
        'jenisSurat',
        'approval.approver',
    ]);

    switch ($request->status) {

        /*
        |--------------------------------------------------------------------------
        | Menunggu Approval
        |--------------------------------------------------------------------------
        */
        case 'approval':

            $query->whereHas('approval', function ($q) {

                $q->where('approver_id', Auth::id())
                  ->where('status', 'Menunggu');

            });

            break;

        /*
        |--------------------------------------------------------------------------
        | Disetujui
        |--------------------------------------------------------------------------
        */
        case 'diterima':

            $query->where('status', 'Disetujui');

            break;

        /*
        |--------------------------------------------------------------------------
        | Ditolak
        |--------------------------------------------------------------------------
        */
        case 'ditolak':

            $query->where('status', 'Ditolak');

            break;

        /*
        |--------------------------------------------------------------------------
        | Sudah Didisposisi
        |--------------------------------------------------------------------------
        */
        case 'disposisi':

            $query->whereHas('disposisi');

            break;

        /*
        |--------------------------------------------------------------------------
        | Semua Surat Selain Draft
        |--------------------------------------------------------------------------
        */
        default:

            $query->where('status', '!=', 'Draft');

            break;
    }

    return response()->json(

        $query->latest()->get()

    );
}

    /*
    |--------------------------------------------------------------------------
    | APPROVE SURAT
    |--------------------------------------------------------------------------
    */
public function approve($id)
{
    $surat = Surat::findOrFail($id);

    $workflow = new ApprovalWorkflowService();

    try {

        DB::transaction(function () use ($workflow, $surat) {

            $workflow->approve($surat, Auth::user());

        });

        return back()->with(
            'success',
            'Surat berhasil disetujui.'
        );

    } catch (\Exception $e) {

        return back()->with(
            'error',
            $e->getMessage()
        );

    }
}

public function reject(Request $request, $id)
{
    $request->validate([
        'catatan' => 'required|string|max:1000',
    ]);

    $surat = Surat::findOrFail($id);

    $workflow = new ApprovalWorkflowService();

    try {

        DB::transaction(function () use ($workflow, $surat, $request) {

            $workflow->reject(
                $surat,
                Auth::user(),
                $request->catatan
            );

        });

        return back()->with(
            'success',
            'Surat berhasil ditolak.'
        );

    } catch (\Exception $e) {

        return back()->with(
            'error',
            $e->getMessage()
        );

    }
}
public function download(Surat $surat)
{
    if (!$surat->file_surat) {
        return back()->with('error', 'File tidak ditemukan.');
    }

    $namaFile = basename($surat->file_surat);

    return Storage::disk('public')
        ->download($surat->file_surat, $namaFile);
}
}