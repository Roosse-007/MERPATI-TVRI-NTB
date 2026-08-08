<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Approval;
use Illuminate\Http\Request;
use Carbon\Carbon;


class GrafikController extends Controller
{

    public function index()
    {

        $tahun = date('Y');


        // TOTAL SURAT MASUK
        $suratMasuk = Surat::where('jenis_surat_id',1)
            ->whereYear('tanggal_surat',$tahun)
            ->count();



        // TOTAL SURAT KELUAR
        $suratKeluar = Surat::where('jenis_surat_id',2)
            ->whereYear('tanggal_surat',$tahun)
            ->count();



        // APPROVAL MENUNGGU

        $approval = Approval::where('status','Menunggu')
            ->count();



        // ARSIP

        $arsip = Surat::where('is_archived',true)
            ->count();



        // GRAFIK BULANAN

        $grafikSurat=[];


        for($i=1;$i<=12;$i++)
        {

            $grafikSurat[$i]=Surat::whereYear('tanggal_surat',$tahun)
                ->whereMonth('tanggal_surat',$i)
                ->count();

        }

// STATUS SURAT

$statusSurat = [
    'Disetujui' => Surat::where('status','Disetujui')->count(),
    'Diproses'  => Surat::where('status','Diproses')->count(),
    'Ditolak'   => Surat::where('status','Ditolak')->count(),
];


// KATEGORI SURAT

$kategoriSurat = Surat::selectRaw('jenis_surat_id, COUNT(*) jumlah')
    ->groupBy('jenis_surat_id')
    ->pluck('jumlah', 'jenis_surat_id');


return view('admin.grafik', compact(
    'suratMasuk',
    'suratKeluar',
    'approval',
    'arsip',
    'grafikSurat',
    'statusSurat',
    'kategoriSurat'
))->with([
    'chartData' => [
        'grafik' => array_values($grafikSurat ?? []),

        'compare' => [
            $suratMasuk ?? 0,
            $suratKeluar ?? 0
        ],

        'status' => [
            $statusSurat['Disetujui'] ?? 0,
            $statusSurat['Diproses'] ?? 0,
            $statusSurat['Ditolak'] ?? 0
        ],

        'kategori'=>[

    $kategoriSurat[1] ?? 0, // Surat Masuk
    $kategoriSurat[2] ?? 0, // Surat Keluar
    $kategoriSurat[3] ?? 0, // Surat Internal
    $kategoriSurat[4] ?? 0, // Nota Dinas
    $kategoriSurat[5] ?? 0, // Surat Produksi
    $kategoriSurat[6] ?? 0, // Surat Undangan
    $kategoriSurat[7] ?? 0  // Surat Tugas

]
    ]
]);
    }
}