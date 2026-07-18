<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Approval;

class DashboardController extends Controller
{

    public function index()
    {

        $user = auth()->user();


        // DATA DASHBOARD SURAT
        $data = [

            // semua surat selain draft
            'suratMasuk' => Surat::where('status', '!=', 'Draft')
                ->count(),


            // surat draft
            'draft' => Surat::where('status', 'Draft')
                ->count(),


            // approval menunggu
            'approval' => Approval::where('status', 'Menunggu')
                ->count(),


            // arsip
            'arsip' => Surat::where('is_archived', true)
                ->count(),

        ];



        /*
        |--------------------------------------------------------------------------
        | DASHBOARD ADMIN
        |--------------------------------------------------------------------------
        */

        if (
            $user &&
            $user->jabatan &&
            $user->jabatan->nama_jabatan === 'Admin'
        ) {

            return view('admin.dashboard', $data);

        }



        /*
        |--------------------------------------------------------------------------
        | DASHBOARD USER BIASA
        |--------------------------------------------------------------------------
        */

        return view('dashboard.index', $data);


    }

}