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
use App\Models\TemplateSurat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



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


            'template_surat_id'

                =>

            'required',



            'jenis_surat_id'

                =>

            'required|exists:jenis_surat,id',



            'sifat_surat_id'

                =>

            'required|exists:sifat_surat,id',



            'nomor_surat'

                =>

            'required|unique:surat,nomor_surat',



            'tanggal_surat'

                =>

            'required|date',



            'deadline'

                =>

            'nullable|date',



            'tujuan_id'

                =>

            'required|exists:users,id',



            'perihal'

                =>

            'required|max:255',



            'isi_surat'

                =>

            'required',



            'file_surat'

                =>

            'nullable|mimes:pdf,doc,docx|max:10240'


        ]);








        /*
        |--------------------------------------------------------------------------
        | STATUS SURAT
        |--------------------------------------------------------------------------
        */


        $status =

            $request->action == 'kirim'

            ?

            'Menunggu Approval KPP'

            :

            'Draft';







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

                ->store(

                    'surat',

                    'public'

                );


        }









        /*
        |--------------------------------------------------------------------------
        | SIMPAN SURAT
        |--------------------------------------------------------------------------
        */


        $surat = Surat::create([



            'template_surat_id'

                =>

            $request->template_surat_id,



            'jenis_surat_id'

                =>

            $request->jenis_surat_id,



            'sifat_surat_id'

                =>

            $request->sifat_surat_id,



            'nomor_surat'

                =>

            $request->nomor_surat,



            'tanggal_surat'

                =>

            $request->tanggal_surat,



            'tanggal_kirim'

                =>

            $status == 'Draft'

            ?

            null

            :

            now(),



            'deadline'

                =>

            $request->deadline,



            'perihal'

                =>

            $request->perihal,



            'isi_surat'

                =>

            $request->isi_surat,



            'file_surat'

                =>

            $file,



            'pengirim_id'

                =>

            Auth::id(),



            'status'

                =>

            $status,



            'is_archived'

                =>

            false



        ]);









        /*
        |--------------------------------------------------------------------------
        | GENERATE DOCX TEMPLATE
        |--------------------------------------------------------------------------
        */


        app(

            \App\Services\SuratGeneratorService::class

        )

        ->generate($surat);









        /*
        |--------------------------------------------------------------------------
        | SIMPAN TUJUAN
        |--------------------------------------------------------------------------
        */


        SuratTujuan::create([


            'surat_id'

                =>

            $surat->id,



            'user_id'

                =>

            $request->tujuan_id,



            'dibaca'

                =>

            false


        ]);









        if($status == 'Draft')
        {


            return redirect()

                ->route('surat.draft')

                ->with(

                    'success',

                    'Draft berhasil disimpan.'

                );


        }







        return redirect()

            ->route('surat.approval')

            ->with(

                'success',

                'Surat berhasil dikirim.'

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


    public function update(
        Request $request,
        $id
    )
    {


        $surat = Surat::findOrFail($id);





        $request->validate([


            'perihal'

                =>

            'required',



            'isi_surat'

                =>

            'required',



            'file_surat'

                =>

            'nullable|file|max:10240'


        ]);








        $file = $surat->file_surat;





        if($request->hasFile('file_surat'))
        {


            if($file)
            {

                Storage::disk('public')

                    ->delete($file);

            }





            $file = $request

                ->file('file_surat')

                ->store(

                    'surat',

                    'public'

                );


        }







        $surat->update([



            'perihal'

                =>

            $request->perihal,



            'isi_surat'

                =>

            $request->isi_surat,



            'file_surat'

                =>

            $file



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
    | HAPUS SURAT
    |--------------------------------------------------------------------------
    */


    public function destroy($id)
    {


        $surat = Surat::findOrFail($id);





        if($surat->file_surat)
        {


            Storage::disk('public')

                ->delete(

                    $surat->file_surat

                );


        }





        $surat->delete();







        return redirect()

            ->route('surat.draft')

            ->with(

                'success',

                'Surat berhasil dihapus.'

            );


    }









    /*
    |--------------------------------------------------------------------------
    | KIRIM SURAT KE APPROVAL
    |--------------------------------------------------------------------------
    */


    public function submit($id)
    {


        $surat = Surat::findOrFail($id);






        if($surat->status !== 'Draft')
        {


            return back()

                ->with(

                    'error',

                    'Surat sudah diproses.'

                );


        }









        $surat->update([



            'status'

                =>

            'Menunggu Approval KPP',



            'tanggal_kirim'

                =>

            now()



        ]);









        /*
        |--------------------------------------------------------------------------
        | BUAT APPROVAL PERTAMA
        |--------------------------------------------------------------------------
        */


        Approval::create([



            'surat_id'

                =>

            $surat->id,



            'approver_id'

                =>

            2,



            'urutan'

                =>

            1,



            'status'

                =>

            'Menunggu',



            'catatan'

                =>

            null



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
    | KOTAK MASUK
    |--------------------------------------------------------------------------
    */


    public function inboxWeb(Request $request)
    {


        $query = Surat::with([


            'pengirim.jabatan',

            'jenisSurat',

            'prioritasSurat'


        ])

        ->where(

            'status',

            '!=',

            'Draft'

        );








        if($request->filled('search'))
        {


            $keyword = $request->search;





            $query->where(function($q) use($keyword){



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

                    function($user) use($keyword){


                        $user->where(

                            'name',

                            'like',

                            "%{$keyword}%"

                        );


                    }

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







        $menungguApproval = Surat::where(

            'status',

            'like',

            'Menunggu%'

        )->count();







        $ditolak = Surat::where(

            'status',

            'Ditolak'

        )->count();







        $disposisi = Disposisi::count();









        return view(

            'surat.inbox',

            compact(

                'surat',

                'totalSurat',

                'menungguApproval',

                'ditolak',

                'disposisi'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | SURAT TERKIRIM API
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



            'prioritasSurat',



            'lampiran',



            'disposisi.keUser.jabatan',



            'approval.approver',



            'pengesahan',



            'balasan'



        ])

        ->findOrFail($id);









        $users = User::with('jabatan')

            ->where(

                'is_active',

                1

            )

            ->where(

                'id',

                '!=',

                Auth::id()

            )

            ->get();









        $aktivitas = collect();







        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS SURAT
        |--------------------------------------------------------------------------
        */


        $aktivitas->push([


            'judul'=>'Surat dibuat',


            'deskripsi'=>$surat->perihal,


            'waktu'=>$surat->created_at



        ]);







        foreach($surat->approval as $item)
        {


            $aktivitas->push([


                'judul'=>'Approval Surat',


                'deskripsi'=>$item->status,


                'waktu'=>$item->created_at



            ]);



        }







        foreach($surat->disposisi as $item)
        {


            $aktivitas->push([


                'judul'=>'Disposisi Surat',


                'deskripsi'=>

                    $item->instruksi,


                'waktu'=>$item->created_at



            ]);



        }








        if($surat->pengesahan)
        {


            $aktivitas->push([


                'judul'=>'Pengesahan Surat',


                'deskripsi'=>

                    $surat->pengesahan->metode,


                'waktu'=>

                    $surat->pengesahan->tanggal_pengesahan



            ]);


        }







        $aktivitas = $aktivitas

            ->sortByDesc('waktu');









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
    | HALAMAN APPROVAL
    |--------------------------------------------------------------------------
    */


    public function approval()
    {


        $surat = Surat::with([


            'pengirim',


            'tujuan.user',


            'approval.approver'


        ])

        ->whereIn(

            'status',

            [


                'Menunggu Approval KPP',


                'Menunggu Approval KTU',


                'Menunggu Approval Kepala Stasiun'


            ]

        )

        ->latest()

        ->paginate(10);








        $totalSurat = Surat::count();





        $menunggu = Surat::whereIn(

            'status',

            [


                'Menunggu Approval KPP',


                'Menunggu Approval KTU',


                'Menunggu Approval Kepala Stasiun'


            ]

        )

        ->count();







        $disetujui = Surat::where(

            'status',

            'Disetujui'

        )

        ->count();







        $ditolak = Surat::where(

            'status',

            'Ditolak'

        )

        ->count();









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

        /*
    |--------------------------------------------------------------------------
    | INBOX KPP
    |--------------------------------------------------------------------------
    */


    public function inboxKpp()
    {


        $surat = Surat::with([


            'pengirim',

            'tujuan.user',

            'approval'


        ])

        ->where(

            'status',

            'Menunggu Approval KPP'

        )

        ->latest()

        ->paginate(10);







        return view(

            'surat.inbox-kpp',

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

            'tujuan.user',

            'approval'


        ])

        ->where(

            'status',

            'Menunggu Approval KTU'

        )

        ->latest()

        ->paginate(10);







        return view(

            'surat.inbox-ktu',

            compact('surat')

        );


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

            'tujuan.user',

            'approval'


        ])

        ->where(

            'status',

            'Menunggu Approval Kepala Stasiun'

        )

        ->latest()

        ->paginate(10);







        return view(

            'surat.inbox-kepala',

            compact('surat')

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





        $status = $surat->status;







        /*
        |--------------------------------------------------------------------------
        | KPP
        |--------------------------------------------------------------------------
        */


        if($status == 'Menunggu Approval KPP')
        {


            Approval::create([


                'surat_id'=>$surat->id,


                'approver_id'=>Auth::id(),


                'urutan'=>1,


                'status'=>'Disetujui',


                'approved_at'=>now()



            ]);






            $surat->update([


                'status'=>

                    'Menunggu Approval KTU'


            ]);



        }









        /*
        |--------------------------------------------------------------------------
        | KTU
        |--------------------------------------------------------------------------
        */


        elseif($status == 'Menunggu Approval KTU')
        {


            Approval::create([


                'surat_id'=>$surat->id,


                'approver_id'=>Auth::id(),


                'urutan'=>2,


                'status'=>'Disetujui',


                'approved_at'=>now()



            ]);







            $surat->update([


                'status'=>

                'Menunggu Approval Kepala Stasiun'


            ]);



        }









        /*
        |--------------------------------------------------------------------------
        | KEPALA STASIUN
        |--------------------------------------------------------------------------
        */


        elseif(
            $status ==
            'Menunggu Approval Kepala Stasiun'
        )
        {


            Approval::create([


                'surat_id'=>$surat->id,


                'approver_id'=>Auth::id(),


                'urutan'=>3,


                'status'=>'Disetujui',


                'approved_at'=>now()



            ]);







            $surat->update([


                'status'=>'Disetujui',


                'tanggal_selesai'=>now()



            ]);



        }








        return back()->with(

            'success',

            'Surat berhasil disetujui.'

        );


    }









    /*
    |--------------------------------------------------------------------------
    | TOLAK SURAT
    |--------------------------------------------------------------------------
    */


    public function reject(
        Request $request,
        $id
    )
    {


        $request->validate([


            'catatan'

                =>

            'required|string'


        ]);







        $surat = Surat::findOrFail($id);








        Approval::create([


            'surat_id'=>$surat->id,


            'approver_id'=>Auth::id(),


            'urutan'=>

                match($surat->status){

                    'Menunggu Approval KPP'
                        => 1,


                    'Menunggu Approval KTU'
                        => 2,


                    default
                        => 3,

                },



            'status'=>'Ditolak',



            'catatan'=>$request->catatan,



            'approved_at'=>now()



        ]);









        $surat->update([


            'status'=>'Ditolak',


            'catatan'=>$request->catatan



        ]);









        return back()->with(

            'success',

            'Surat berhasil ditolak.'

        );


    }



}