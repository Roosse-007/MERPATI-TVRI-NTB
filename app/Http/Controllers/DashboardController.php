<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Disposisi;
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
'approval' => Surat::whereIn('status', [
    'Menunggu Approval KPP',
    'Menunggu Approval KTU',
    'Menunggu Approval Kepala Stasiun',
])->count(),

            // arsip
            'arsip' => Surat::where('is_archived', true)
                ->count(),

        ];

        // Aktivitas terbaru
        $aktivitas = collect();

        // Surat terbaru
        $suratTerbaru = Surat::latest()->take(5)->get();

        foreach ($suratTerbaru as $surat) {
            $aktivitas->push([
                'judul' => 'Surat Baru',
                'deskripsi' => $surat->perihal,
                'status' => 'Baru',
                'waktu' => $surat->created_at,
            ]);
        }

        // Approval terbaru
        $approvalTerbaru = Approval::with('surat')
            ->latest()
            ->take(5)
            ->get();

        foreach ($approvalTerbaru as $approval) {
            $aktivitas->push([
                'judul' => 'Approval Surat',
                'deskripsi' => $approval->surat->perihal ?? '-',
                'status' => $approval->status,
                'waktu' => $approval->created_at,
            ]);
        }

        // Disposisi terbaru
        $disposisiTerbaru = Disposisi::with('surat')
            ->latest()
            ->take(5)
            ->get();

        foreach ($disposisiTerbaru as $disposisi) {
            $aktivitas->push([
                'judul' => 'Disposisi Surat',
                'deskripsi' => $disposisi->surat->perihal ?? '-',
                'status' => 'Disposisi',
                'waktu' => $disposisi->created_at,
            ]);
        }

        // Urutkan berdasarkan waktu terbaru
        $data['aktivitas'] = $aktivitas
            ->sortByDesc('waktu')
            ->take(8);



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