<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Approval;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{

    public function index()
    {

        $user = Auth::user();


        // DATA DASHBOARD SURAT
        $data = [

    'suratMasuk' => Surat::where('status', '!=', 'Draft')->count(),

    'draft' => Surat::where('status', 'Draft')->count(),

    'approval' => Approval::where('status', 'Menunggu')->count(),

    'arsip' => Surat::where('is_archived', true)->count(),


    // DATA GRAFIK BULANAN
    'grafikSurat' => Surat::selectRaw('MONTH(tanggal_surat) bulan, COUNT(*) jumlah')
        ->whereYear('tanggal_surat', 2026)
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->pluck('jumlah','bulan'),


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