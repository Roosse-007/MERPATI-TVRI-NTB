<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Approval;

class DashboardController extends Controller
{

    public function index()
    {

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


        return view('dashboard.index', $data);

    }

}