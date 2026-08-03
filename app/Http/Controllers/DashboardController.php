<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Disposisi;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $jabatan = $user->jabatan->nama_jabatan ?? '';


        /*
        |--------------------------------------------------------------------------
        | STATISTIK GLOBAL
        |--------------------------------------------------------------------------
        */

        $totalSurat = Surat::count();

        $totalUser = User::count();

        $pendingApproval = Approval::where('status','Menunggu')->count();

        $totalArsip = Surat::where('is_archived', true)->count();



        /*
        |--------------------------------------------------------------------------
        | GRAFIK SURAT BULANAN
        |--------------------------------------------------------------------------
        */

        $statistikSurat = Surat::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get()
            ->map(function ($item) {

                return [
                    'bulan' => date(
                        'M',
                        mktime(0,0,0,$item->bulan,1)
                    ),

                    'jumlah' => $item->jumlah,
                ];
            });



        /*
        |--------------------------------------------------------------------------
        | STATUS SURAT
        |--------------------------------------------------------------------------
        */

        $statusSurat = Surat::select(
                'status',
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('status')
            ->get();



        /*
        |--------------------------------------------------------------------------
        | SURAT TERBARU GLOBAL
        |--------------------------------------------------------------------------
        */

        $suratTerbaru = Surat::latest()
            ->take(5)
            ->get();



        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS TERBARU USER
        |--------------------------------------------------------------------------
        */

        $aktivitas = collect();



        /*
        |--------------------------------------------------------------------------
        | SURAT DIBUAT USER
        |--------------------------------------------------------------------------
        */

        $suratSaya = Surat::where('pengirim_id',$user->id)
            ->latest()
            ->take(5)
            ->get();


        foreach($suratSaya as $surat){

            $aktivitas->push([

                'judul'=>'Surat Dibuat',

                'deskripsi'=>$surat->perihal,

                'status'=>$surat->status,

                'waktu'=>$surat->created_at,

            ]);

        }




        /*
        |--------------------------------------------------------------------------
        | SURAT MASUK USER
        |--------------------------------------------------------------------------
        */

        $suratMasukSaya = Surat::where(function($q) use ($user){

            // surat langsung
            $q->whereHas('tujuan', function($sub) use ($user){

                $sub->where('user_id',$user->id);

            })

            // approval masuk
            ->orWhereHas('approval', function($sub) use ($user){

                $sub->where('approver_id',$user->id)
                    ->where('status','Menunggu');

            });


        })
        ->latest()
        ->take(5)
        ->get();



        foreach($suratMasukSaya as $surat){

            $aktivitas->push([

                'judul'=>'Surat Masuk',

                'deskripsi'=>$surat->perihal,

                'status'=>$surat->status,

                'waktu'=>$surat->created_at,

            ]);

        }




        /*
        |--------------------------------------------------------------------------
        | DISPOSISI USER
        |--------------------------------------------------------------------------
        */

        $disposisiSaya = Disposisi::with('surat')
            ->where('ke_user_id',$user->id)
            ->latest()
            ->take(5)
            ->get();



        foreach($disposisiSaya as $disposisi){

            $aktivitas->push([

                'judul'=>'Disposisi Surat',

                'deskripsi'=>$disposisi->surat->perihal ?? '-',

                'status'=>$disposisi->status,

                'waktu'=>$disposisi->created_at,

            ]);

        }





        /*
        |--------------------------------------------------------------------------
        | APPROVAL USER (SUDAH DIPROSES)
        |--------------------------------------------------------------------------
        */

        $approvalSaya = Approval::with('surat')
            ->where('approver_id',$user->id)
            ->whereIn('status',[
                'Disetujui',
                'Ditolak'
            ])
            ->latest()
            ->take(5)
            ->get();



        foreach($approvalSaya as $approval){

            $aktivitas->push([

                'judul'=>'Approval Surat',

                'deskripsi'=>$approval->surat->perihal ?? '-',

                'status'=>$approval->status,

                'waktu'=>$approval->created_at,

            ]);

        }




        $aktivitas = $aktivitas
            ->sortByDesc('waktu')
            ->unique(function($item){

                return $item['judul'].'-'.$item['deskripsi'];

            })
            ->values();



        $page = request()->get('page',1);

        $perPage = 8;


        $aktivitas = new LengthAwarePaginator(

            $aktivitas->forPage($page,$perPage),

            $aktivitas->count(),

            $perPage,

            $page,

            [
                'path'=>request()->url()
            ]

        );




        /*
        |--------------------------------------------------------------------------
        | CARD DASHBOARD ROLE
        |--------------------------------------------------------------------------
        */


        if($user->hasRole('Admin')){


            $suratMasuk = Surat::where('status','!=','Draft')
                ->count();


            $draft = Surat::where('status','Draft')
                ->count();


            $approval = Approval::where('status','Menunggu')
                ->count();


            $diterima = Surat::where('status','Disetujui')
                ->count();


            $arsip = Surat::where('is_archived',true)
                ->count();


}elseif(
    in_array($jabatan,[
        'Ketua Tim Perencana dan Pengendali Program',
        'Kepala Sub Bagian Tata Usaha',
        'Kepala TVRI Stasiun NTB'
    ])
){

    /*
    |--------------------------------------------------------------------------
    | SURAT MASUK USER
    |--------------------------------------------------------------------------
    */

    $suratMasuk = Surat::whereHas('tujuan', function($q) use ($user){

        $q->where('user_id',$user->id);

    })
    ->where('status','!=','Draft')
    ->count();



    /*
    |--------------------------------------------------------------------------
    | DRAFT USER
    |--------------------------------------------------------------------------
    */

    $draft = Surat::where('pengirim_id',$user->id)
        ->where('status','Draft')
        ->count();



    /*
    |--------------------------------------------------------------------------
    | APPROVAL USER
    |--------------------------------------------------------------------------
    */

    $approval = Approval::where('approver_id',$user->id)
        ->where('status','Menunggu')
        ->count();



    /*
    |--------------------------------------------------------------------------
    | SURAT DISETUJUI USER
    |--------------------------------------------------------------------------
    */

    $diterima = Surat::whereHas('tujuan', function($q) use ($user){

        $q->where('user_id',$user->id);

    })
    ->where('status','Disetujui')
    ->count();



    /*
    |--------------------------------------------------------------------------
    | ARSIP USER
    |--------------------------------------------------------------------------
    */

    $arsip = Surat::whereHas('tujuan', function($q) use ($user){

        $q->where('user_id',$user->id);

    })
    ->where('is_archived',true)
    ->count();





        }else{


            $suratMasuk = Surat::whereHas('tujuan',function($q)use($user){

                $q->where('user_id',$user->id);

            })
            ->where('status','!=','Draft')
            ->count();



            $draft = Surat::where('pengirim_id',$user->id)
                ->where('status','Draft')
                ->count();



            $approval = Approval::where('approver_id',$user->id)
                ->where('status','Menunggu')
                ->count();



            $diterima = Surat::where('pengirim_id',$user->id)
                ->where('status','Disetujui')
                ->count();



            $arsip = Surat::where('pengirim_id',$user->id)
                ->where('is_archived',true)
                ->count();


        }




        $data = [

            'totalSurat'=>$totalSurat,

            'totalUser'=>$totalUser,

            'pendingApproval'=>$pendingApproval,

            'totalArsip'=>$totalArsip,


            'suratMasuk'=>$suratMasuk,

            'draft'=>$draft,

            'approval'=>$approval,

            'diterima'=>$diterima,

            'arsip'=>$arsip,


            'statistikSurat'=>$statistikSurat,

            'statusSurat'=>$statusSurat,

            'aktivitas'=>$aktivitas,

            'suratTerbaru'=>$suratTerbaru,

        ];




        if(request()->ajax()){

            return view(
                'dashboard.partials.aktivitas',
                [
                    'aktivitas'=>$aktivitas
                ]
            );

        }



        if($user->hasRole('Admin')){

            return view('admin.dashboard',$data);

        }


        return view('dashboard.index',$data);

    }
}