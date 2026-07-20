<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSuratRequest;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
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

    public function indexWeb()
    {
        $surat = Surat::with([
            'pengirim.jabatan',
            'prioritasSurat',
            'disposisi.dariUser',
            'disposisi.keUser'
        ])
        ->where('status', 'Disetujui')
        ->latest()
        ->paginate(10);

        $users = User::with('jabatan')
            ->orderBy('name')
            ->get();

        return view('surat.disposisi', compact(
            'surat',
            'users'
        ));
    }

    public function store(StoreSuratRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('file_surat')) {

            $file = $request->file('file_surat');

            $namaFile = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('surat', $namaFile, 'public');

            $data['file_surat'] = $namaFile;
        }

        // sementara pakai admin
        $data['pengirim_id'] = Auth::id();

        $data['status'] = 'Draft';
        $data['is_archived'] = false;

        $surat = Surat::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Surat berhasil disimpan sebagai Draft.',
            'data' => $surat
        ], 201);
    }
    public function draft()
{
    $draft = Surat::with([
        'pengirim',
        'jenisSurat',
        'prioritasSurat'
    ])
    ->where('status', 'Draft')
    ->latest()
    ->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'Daftar Draft Surat',
        'data' => $draft
    ]);
}
public function draftWeb()
{
    $surat = Surat::where('status','Draft')
        ->paginate(10);


    return view('surat.draft', compact('surat'));
}
public function submit($id)
{
    // Cari surat berdasarkan ID
    $surat = Surat::findOrFail($id);

    // Jika surat tidak ditemukan
    

    // Hanya surat Draft yang boleh dikirim
    if ($surat->status !== 'Draft') {
        return response()->json([
            'success' => false,
            'message' => 'Hanya surat Draft yang dapat dikirim.'
        ], 400);
    }

    // Ubah status
    $surat->status = 'Menunggu Verifikasi KPP';
    $surat->tanggal_kirim = now();
    $surat->save();

    return response()->json([
        'success' => true,
        'message' => 'Surat berhasil dikirim ke KPP.',
        'data' => $surat
    ]);
}
public function inbox()
{
        $surat = Surat::with([
        'pengirim.jabatan',
        'jenisSurat',
        'prioritasSurat'
    ])
    ->where('pengirim_id', Auth::id())
    ->latest('tanggal_kirim')
    ->paginate(10);


    return response()->json([

        'success'=>true,

        'message'=>'Daftar Surat Masuk',

        'data'=>$surat->through(function($item){

            return [

                'id'=>$item->id,

                'nomor_surat'=>$item->nomor_surat,

                'perihal'=>$item->perihal,

                'ringkasan'=>$item->ringkasan,

                'tanggal_surat'=>$item->tanggal_surat,

                'status'=>$item->status,


                'pengirim'=>[

                    'nama'=>$item->pengirim->name ?? null,

                    'jabatan'=>$item->pengirim->jabatan->nama_jabatan ?? null

                ],


                'prioritas'=>$item->prioritasSurat->nama_prioritas ?? null

            ];

        })

    ]);

}
public function inboxWeb(Request $request)
{
    $query = Surat::with([
        'pengirim.jabatan',
        'jenisSurat',
        'prioritasSurat'
    ])
    ->where('status', '!=', 'Draft');

    // Search
    if ($request->filled('search')) {

        $keyword = $request->search;

        $query->where(function ($q) use ($keyword) {

            $q->where('nomor_surat', 'like', "%{$keyword}%")
              ->orWhere('perihal', 'like', "%{$keyword}%")
              ->orWhere('ringkasan', 'like', "%{$keyword}%")
              ->orWhereHas('pengirim', function ($user) use ($keyword) {

                    $user->where('name', 'like', "%{$keyword}%");

              });

        });
    }

    // Filter Status
    if ($request->filled('status')) {

        $query->where('status', $request->status);

    }

    $surat = $query
        ->latest('tanggal_surat')
        ->paginate(10)
        ->withQueryString();

    $totalSurat = Surat::where('status', '!=', 'Draft')->count();

    $diproses = Surat::where('status', 'Diproses')->count();

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
public function inboxKtu()
{
    $surat = Surat::with([
        'pengirim',
        'jenisSurat',
        'prioritasSurat'
    ])
    ->where('status', 'Menunggu Paraf KTU')
    ->latest()
    ->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'Kotak Masuk KTU',
        'data' => $surat
    ]);
}
public function inboxKepalaStasiun()
{
    $surat = Surat::with([
        'pengirim',
        'jenisSurat',
        'prioritasSurat'
    ])
    ->where('status', 'Menunggu Persetujuan Kepala Stasiun')
    ->latest()
    ->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'Kotak Masuk Kepala Stasiun',
        'data' => $surat
    ]);
}
public function sent()
{

$surat = Surat::with([
    'pengirim.jabatan',
    'jenisSurat'
])
->where('pengirim_id',1)
->paginate(10);



return response()->json([

    'success'=>true,

    'message'=>'Daftar Surat Terkirim',

    'data'=>$surat->through(function($item){

        return [

            'id'=>$item->id,

            'nomor_surat'=>$item->nomor_surat,

            'perihal'=>$item->perihal,

            'tanggal_kirim'=>$item->tanggal_kirim,

            'status'=>$item->status,


            'pengirim'=>[

                'nama'=>$item->pengirim->name ?? null,

                'jabatan'=>$item->pengirim->jabatan->nama_jabatan ?? null

            ]

        ];

    })

]);
}
public function archive($id)
{
    $surat = Surat::findOrFail($id);


    if ($surat->status !== 'Disetujui') {
        return response()->json([
            'success' => false,
            'message' => 'Surat belum dapat diarsipkan.'
        ], 400);
    }


    $surat->update([
        'is_archived' => true
    ]);


    return response()->json([
        'success' => true,
        'message' => 'Surat berhasil diarsipkan.',
        'data' => $surat
    ]);
}
public function archiveList()
{

    $surat = Surat::where('is_archived', true)

        ->with([
            'pengirim.jabatan',
            'jenisSurat'
        ])

        ->paginate(10);



    return response()->json([

        'success'=>true,

        'message'=>'Daftar Surat Arsip',


        'data'=>$surat->through(function($item){

            return [

'id'=>$item->id,

'nomor_surat'=>$item->nomor_surat,

'perihal'=>$item->perihal,

'tanggal_surat'=>$item->tanggal_surat,

'tanggal_kirim'=>$item->tanggal_kirim,

'status'=>$item->status,

'is_archived'=>$item->is_archived,


                'pengirim'=>[

                    'nama'=>$item->pengirim->name ?? null,

                    'jabatan'=>$item->pengirim->jabatan->nama_jabatan ?? null

                ]

            ];

        })

    ]);

}
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
    ])->findOrFail($id);


   
    

    return response()->json([

        'success'=>true,

        'message'=>'Detail Surat',

        'data'=>[

            'id'=>$surat->id,

            'nomor_surat'=>$surat->nomor_surat,

            'perihal'=>$surat->perihal,

            'ringkasan'=>$surat->ringkasan,

            'isi_surat'=>$surat->isi_surat,

            'tanggal_surat'=>$surat->tanggal_surat,

            'status'=>$surat->status,


            'pengirim'=>[

                'nama'=>$surat->pengirim->name ?? null,

                'jabatan'=>$surat->pengirim->jabatan->nama_jabatan ?? null

            ],


            'approval'=>$surat->approval->map(function($item){

    return [

        'id'=>$item->id,

        'urutan'=>$item->urutan,

                    'nama'=>$item->approver->name ?? null,

                    'jabatan'=>$item->approver->jabatan->nama_jabatan ?? null,

                    'status'=>$item->status,

                    'tanggal'=>$item->approved_at

                ];

            }),



            'disposisi'=>$surat->disposisi->map(function($item){

                return [
                        'id'=>$item->id,

                    'dari'=>$item->dariUser->name ?? null,

                    'ke'=>$item->keUser->name ?? null,

                    'instruksi'=>$item->instruksi,

                    'status'=>$item->status,

                    'dibaca'=>$item->dibaca

                ];

            })


        ]

    ]);
    
}

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
    ])->findOrFail($id);

    return view('surat.show', compact('surat'));
}

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

    return view('surat.arsip', compact('surat'));
}
}