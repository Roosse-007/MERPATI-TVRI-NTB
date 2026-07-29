<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Disposisi;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

        $pendingApproval = Surat::whereIn('status', [
            'Menunggu Approval KPP',
            'Menunggu Approval KTU',
            'Menunggu Approval Kepala Stasiun',
        ])->count();

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
                        mktime(0, 0, 0, $item->bulan, 1)
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
        | AKTIVITAS TERBARU
        |--------------------------------------------------------------------------
        */

        $aktivitas = collect();

        $suratTerbaru = Surat::latest()
            ->take(5)
            ->get();

        foreach ($suratTerbaru as $surat) {

            $aktivitas->push([
                'judul'      => 'Surat Baru',
                'deskripsi'  => $surat->perihal,
                'status'     => 'Baru',
                'waktu'      => $surat->created_at,
            ]);
        }

        $approvalTerbaru = Approval::with('surat')
            ->latest()
            ->take(5)
            ->get();

        foreach ($approvalTerbaru as $approval) {

            $aktivitas->push([
                'judul'      => 'Approval Surat',
                'deskripsi'  => $approval->surat->perihal ?? '-',
                'status'     => $approval->status,
                'waktu'      => $approval->created_at,
            ]);
        }

        $disposisiTerbaru = Disposisi::with('surat')
            ->latest()
            ->take(5)
            ->get();

        foreach ($disposisiTerbaru as $disposisi) {

            $aktivitas->push([
                'judul'      => 'Disposisi Surat',
                'deskripsi'  => $disposisi->surat->perihal ?? '-',
                'status'     => 'Disposisi',
                'waktu'      => $disposisi->created_at,
            ]);
        }

        $aktivitas = $aktivitas
            ->sortByDesc('waktu')
            ->take(8)
            ->values();
            

            /*
        |--------------------------------------------------------------------------
        | DASHBOARD BERDASARKAN ROLE
        |--------------------------------------------------------------------------
        */

if ($user->hasRole('Admin')) {

    $suratMasuk = Surat::where('status', '!=', 'Draft')->count();

    $draft = Surat::where('status', 'Draft')->count();

    $approval = Surat::whereIn('status', [
        'Menunggu Approval KPP',
        'Menunggu Approval KTU',
        'Menunggu Approval Kepala Stasiun',
    ])->count();

    $diterima = Surat::where('status', 'Disetujui')->count();

    $arsip = Surat::where('is_archived', true)->count();

    $diterima = Surat::where('status', 'Disetujui')->count();

    $arsip = Surat::where('is_archived', true)->count();

} elseif ($jabatan === 'Ketua Tim Perencana dan Pengendali Program') {

            $suratMasuk = Surat::where(
                'status',
                'Menunggu Approval KPP'
            )->count();

            $draft = Surat::where('pengirim_id', $user->id)
                ->where('status', 'Draft')
                ->count();

            $approval = Surat::where(
                'status',
                'Menunggu Approval KPP'
            )->count();

            $diterima = Surat::where(
                'status',
                'Disetujui'
            )->count();

            $arsip = Surat::where(
                'is_archived',
                true
            )->count();

        } elseif ($jabatan === 'Kepala Sub Bagian Tata Usaha') {

            $suratMasuk = Surat::where(
                'status',
                'Menunggu Approval KTU'
            )->count();

            $draft = Surat::where('pengirim_id', $user->id)
                ->where('status', 'Draft')
                ->count();

            $approval = Surat::where(
                'status',
                'Menunggu Approval KTU'
            )->count();

            $diterima = Surat::where(
                'status',
                'Disetujui'
            )->count();

            $arsip = Surat::where(
                'is_archived',
                true
            )->count();

        } elseif ($jabatan === 'Kepala TVRI Stasiun NTB') {

            $suratMasuk = Surat::where(
                'status',
                'Menunggu Approval Kepala Stasiun'
            )->count();

            $draft = Surat::where('pengirim_id', $user->id)
                ->where('status', 'Draft')
                ->count();

            $approval = Surat::where(
                'status',
                'Menunggu Approval Kepala Stasiun'
            )->count();

            $diterima = Surat::where(
                'status',
                'Disetujui'
            )->count();

            $arsip = Surat::where(
                'is_archived',
                true
            )->count();

        } else {

            $suratMasuk = Surat::where('pengirim_id', $user->id)
                ->where('status', '!=', 'Draft')
                ->count();

            $draft = Surat::where('pengirim_id', $user->id)
                ->where('status', 'Draft')
                ->count();

            $approval = Surat::where('pengirim_id', $user->id)
            ->whereIn('status', [
                'Menunggu Approval KPP',
                'Menunggu Approval KTU',
                'Menunggu Approval Kepala Stasiun',
            ])
            ->count();

            $diterima = Surat::where('pengirim_id', $user->id)
                ->where('status', 'Disetujui')
                ->count();

            $arsip = Surat::where('pengirim_id', $user->id)
                ->where('is_archived', true)
                ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | DATA YANG DIKIRIM KE VIEW
        |--------------------------------------------------------------------------
        */

        $data = [
            'totalSurat'       => $totalSurat,
            'totalUser'        => $totalUser,
            'pendingApproval'  => $pendingApproval,
            'totalArsip'       => $totalArsip,

            'suratMasuk'       => $suratMasuk,
            'draft'            => $draft,
            'approval'         => $approval,
            'diterima'         => $diterima,
            'arsip'            => $arsip,

            'statistikSurat'   => $statistikSurat,
            'statusSurat'      => $statusSurat,
            'aktivitas'        => $aktivitas,
            'suratTerbaru'     => $suratTerbaru,
        ];

                /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('Admin')) {

            return view('admin.dashboard', $data);

        }

        return view('dashboard.index', $data);
    }
}