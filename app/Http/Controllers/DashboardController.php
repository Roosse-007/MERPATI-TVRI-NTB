<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\User;
use App\Models\Approval;
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

                DB::raw('MONTH(created_at) as bulan'),

                DB::raw('COUNT(*) as jumlah')

            )
            ->groupBy(
                DB::raw('MONTH(created_at)')
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

                DB::raw('COUNT(*) as jumlah')

            )
            ->groupBy('status')
            ->get();







        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS TERBARU
        |--------------------------------------------------------------------------
        */


        $aktivitas = Surat::latest()
            ->limit(3)
            ->get();







        /*
        |--------------------------------------------------------------------------
        | SURAT TERBARU
        |--------------------------------------------------------------------------
        */


        $suratTerbaru = Surat::latest()
            ->limit(5)
            ->get();







        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
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
        ){

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