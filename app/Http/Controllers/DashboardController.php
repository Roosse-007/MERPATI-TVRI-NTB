<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\User;
use App\Models\Approval;
use App\Models\Disposisi;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{


    public function index()
    {


        $user = auth()->user();



        /*
        |--------------------------------------------------------------------------
        | STATISTIK CARD
        |--------------------------------------------------------------------------
        */


        $totalSurat = Surat::count();


        $totalUser = User::count();



        $pendingApproval = Approval::where(
            'status',
            'Menunggu'
        )->count();



        $totalArsip = Surat::where(
            'is_archived',
            true
        )->count();






        /*
        |--------------------------------------------------------------------------
        | GRAFIK SURAT BULANAN
        |--------------------------------------------------------------------------
        */


        $statistikSurat = Surat::select(

                DB::raw(
                    'MONTH(created_at) as bulan'
                ),

                DB::raw(
                    'COUNT(*) as jumlah'
                )

            )

            ->groupBy(
                DB::raw(
                    'MONTH(created_at)'
                )
            )

            ->orderBy('bulan')

            ->get()

            ->map(function($item){


                return [

                    'bulan'=>date(
                        'M',
                        mktime(
                            0,
                            0,
                            0,
                            $item->bulan,
                            1
                        )
                    ),


                    'jumlah'=>$item->jumlah

                ];


            });








        /*
        |--------------------------------------------------------------------------
        | STATUS SURAT
        |--------------------------------------------------------------------------
        */


        $statusSurat = Surat::select(

                'status',

                DB::raw(
                    'COUNT(*) as jumlah'
                )

            )

            ->groupBy('status')

            ->get();









        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS TERBARU
        |--------------------------------------------------------------------------
        */


        $aktivitas = collect();




        /*
        | Surat Baru
        */

        $suratTerbaru = Surat::latest()
            ->take(5)
            ->get();



        foreach($suratTerbaru as $surat)
        {

            $aktivitas->push([

                'judul'=>'Surat Baru',

                'deskripsi'=>$surat->perihal,

                'status'=>'Baru',

                'waktu'=>$surat->created_at

            ]);

        }





        /*
        | Approval
        */

        $approvalTerbaru = Approval::with('surat')
            ->latest()
            ->take(5)
            ->get();



        foreach($approvalTerbaru as $approval)
        {

            $aktivitas->push([

                'judul'=>'Approval Surat',

                'deskripsi'=>$approval->surat->perihal ?? '-',

                'status'=>$approval->status,

                'waktu'=>$approval->created_at

            ]);

        }







        /*
        | Disposisi
        */

        $disposisiTerbaru = Disposisi::with('surat')
            ->latest()
            ->take(5)
            ->get();



        foreach($disposisiTerbaru as $disposisi)
        {

            $aktivitas->push([

                'judul'=>'Disposisi Surat',

                'deskripsi'=>$disposisi->surat->perihal ?? '-',

                'status'=>'Disposisi',

                'waktu'=>$disposisi->created_at

            ]);

        }





        $aktivitas = $aktivitas
            ->sortByDesc('waktu')
            ->take(8);







        /*
        |--------------------------------------------------------------------------
        | DATA VIEW
        |--------------------------------------------------------------------------
        */


        $data = [


            'totalSurat'=>$totalSurat,


            'totalUser'=>$totalUser,


            'pendingApproval'=>$pendingApproval,


            'totalArsip'=>$totalArsip,


            'statistikSurat'=>$statistikSurat,


            'statusSurat'=>$statusSurat,


            'aktivitas'=>$aktivitas,


            'suratTerbaru'=>$suratTerbaru,


        ];









        /*
        |--------------------------------------------------------------------------
        | DASHBOARD ADMIN
        |--------------------------------------------------------------------------
        */


        if(
            $user &&
            $user->jabatan &&
            $user->jabatan->nama_jabatan === 'Admin'
        )
        {


            return view(

                'admin.dashboard',

                $data

            );


        }







        /*
        |--------------------------------------------------------------------------
        | DASHBOARD USER
        |--------------------------------------------------------------------------
        */


        return view(

            'dashboard.index',

            $data

        );


    }


}