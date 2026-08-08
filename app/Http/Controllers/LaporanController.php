<?php

namespace App\Http\Controllers;

use App\Models\Surat;
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



    // UNTUK TABEL (TETAP PAGINATION)
    $laporan = $query
        ->latest()
        ->paginate(10);



    $suratMasuk = Surat::where(
        'jenis_surat_id',
        1
    )->count();



    $suratKeluar = Surat::where(
        'jenis_surat_id',
        2
    )->count();



    $approval = Surat::where(
        'status',
        'Menunggu Approval'
    )->count();



    $arsip = Surat::where(
        'is_archived',
        1
    )->count();



    $jenisSurat = JenisSurat::all();



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





public function export(Request $request)
{

    $query = Surat::with('jenisSurat');


    if($request->filled('dari')){

        $query->whereDate(
            'created_at',
            '>=',
            $request->dari
        );

    }


    if($request->filled('sampai')){

        $query->whereDate(
            'created_at',
            '<=',
            $request->sampai
        );

    }


    if($request->filled('jenis')){

        $query->where(
            'jenis_surat_id',
            $request->jenis
        );

    }


    if($request->filled('status')){

        $query->where(
            'status',
            $request->status
        );

    }



    // AMBIL SEMUA DATA TANPA PAGINATION
    $laporan = $query
        ->latest()
        ->get();



    $csv = [];



    $csv[] = [
        'No',
        'Nomor Surat',
        'Jenis',
        'Perihal',
        'Tanggal',
        'Status'
    ];



    foreach($laporan as $index=>$item){

        $csv[] = [

            $index + 1,

            $item->nomor_surat,

            $item->jenisSurat->nama_jenis ?? '-',

            $item->perihal,

            $item->created_at->format('d-m-Y'),

            $item->status

        ];

    }



    $handle = fopen('php://temp','r+');


    foreach($csv as $row){

        fputcsv(
            $handle,
            $row
        );

    }


    rewind($handle);


    $content = stream_get_contents($handle);


    fclose($handle);



    return response($content)

        ->header(
            'Content-Type',
            'text/csv'
        )

        ->header(
            'Content-Disposition',
            'attachment; filename="laporan-surat.csv"'
        );


}


}