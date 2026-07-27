<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Approval;
use App\Models\Arsip;
use App\Models\JenisSurat;
use Illuminate\Http\Request;


class LaporanController extends Controller
{


public function index(Request $request)
{


    $query = Surat::with('jenisSurat');



    // FILTER TANGGAL AWAL

    if($request->filled('dari')){


        $query->whereDate(
            'created_at',
            '>=',
            $request->dari
        );


    }



    // FILTER TANGGAL AKHIR

    if($request->filled('sampai')){


        $query->whereDate(
            'created_at',
            '<=',
            $request->sampai
        );


    }



    // FILTER JENIS

    if($request->filled('jenis')){


        $query->where(
            'jenis_surat_id',
            $request->jenis
        );


    }





    // FILTER STATUS

    if($request->filled('status')){


        $query->where(
            'status',
            $request->status
        );


    }





    $laporan =
        $query
        ->latest()
        ->paginate(10);







   // =========================
// STATISTIK LAPORAN
// =========================


// Surat Masuk
$suratMasuk = Surat::where(
    'jenis_surat_id',
    1
)->count();



// Surat Keluar
$suratKeluar = Surat::where(
    'jenis_surat_id',
    2
)->count();



// Approval
$approval = Surat::where(
    'status',
    'Menunggu Approval'
)->count();



// Arsip
$arsip = Surat::where(
    'is_archived',
    1
)->count();

    $jenisSurat =
        JenisSurat::all();





   return view(
    'admin.laporan',
    compact(
        'laporan',
        'suratMasuk',
        'suratKeluar',
        'approval',
        'arsip',
        'jenisSurat'
    )
);


}




}