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
        $jabatan = $user->jabatan->nama_jabatan ?? '';

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD ADMIN
        |--------------------------------------------------------------------------
        */

        if ($jabatan == 'Admin') {

            $data = [

                'suratMasuk' => Surat::where('status', '!=', 'Draft')->count(),

                'draft' => Surat::where('status', 'Draft')->count(),

                'approval' => Surat::whereIn('status', [
                    'Menunggu Approval KPP',
                    'Menunggu Approval KTU',
                    'Menunggu Approval Kepala Stasiun',
                ])->count(),

                'diterima' => Surat::where('status', 'Disetujui')->count(),

                'arsip' => Surat::where('is_archived', true)->count(),

            ];

        }

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD KPP
        |--------------------------------------------------------------------------
        */

        elseif ($jabatan == 'Ketua Tim Perencana dan Pengendali Program') {

            $data = [

                'suratMasuk' => Surat::where('status', 'Menunggu Approval KPP')->count(),

                'draft' => Surat::where('pengirim_id', $user->id)
                    ->where('status', 'Draft')
                    ->count(),

                'approval' => Surat::where('status', 'Menunggu Approval KPP')->count(),

                'diterima' => Surat::where('status', 'Disetujui')->count(),

                'arsip' => Surat::where('is_archived', true)->count(),

            ];

        }

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD KTU
        |--------------------------------------------------------------------------
        */

        elseif ($jabatan == 'Kepala Sub Bagian Tata Usaha') {

            $data = [

                'suratMasuk' => Surat::where('status', 'Menunggu Approval KTU')->count(),

                'draft' => Surat::where('pengirim_id', $user->id)
                    ->where('status', 'Draft')
                    ->count(),

                'approval' => Surat::where('status', 'Menunggu Approval KTU')->count(),

                'diterima' => Surat::where('status', 'Disetujui')->count(),

                'arsip' => Surat::where('is_archived', true)->count(),

            ];

        }

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD KEPALA TVRI STASIUN NTB
        |--------------------------------------------------------------------------
        */

        elseif ($jabatan == 'Kepala TVRI Stasiun NTB') {

            $data = [

                'suratMasuk' => Surat::where('status', 'Menunggu Approval Kepala Stasiun')->count(),

                'draft' => Surat::where('pengirim_id', $user->id)
                    ->where('status', 'Draft')
                    ->count(),

                'approval' => Surat::where('status', 'Menunggu Approval Kepala Stasiun')->count(),

                'diterima' => Surat::where('status', 'Disetujui')->count(),

                'arsip' => Surat::where('is_archived', true)->count(),

            ];

        }

        /*
        |--------------------------------------------------------------------------
        | USER BIASA
        |--------------------------------------------------------------------------
        */

        else {

            $data = [

                'suratMasuk' => Surat::where('pengirim_id', $user->id)
                    ->where('status', '!=', 'Draft')
                    ->count(),

                'draft' => Surat::where('pengirim_id', $user->id)
                    ->where('status', 'Draft')
                    ->count(),

                'approval' => Approval::where('approver_id', $user->id)->count(),

                'diterima' => Surat::where('pengirim_id', $user->id)
                    ->where('status', 'Disetujui')
                    ->count(),

                'arsip' => Surat::where('pengirim_id', $user->id)
                    ->where('is_archived', true)
                    ->count(),

            ];

        }

        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS TERBARU
        |--------------------------------------------------------------------------
        */

        $aktivitas = collect();

        $query = Surat::query();

        if ($jabatan == 'Ketua Tim Perencana dan Pengendali Program') {

            $query->where('status', 'Menunggu Approval KPP');

        } elseif ($jabatan == 'Kepala Sub Bagian Tata Usaha') {

            $query->where('status', 'Menunggu Approval KTU');

        } elseif ($jabatan == 'Kepala TVRI Stasiun NTB') {

            $query->where('status', 'Menunggu Approval Kepala Stasiun');

        } elseif ($jabatan != 'Admin') {

            $query->where('pengirim_id', $user->id);

        }

        foreach ($query->latest()->take(5)->get() as $surat) {

            $aktivitas->push([
                'judul' => 'Surat',
                'deskripsi' => $surat->perihal,
                'status' => $surat->status,
                'waktu' => $surat->created_at,
            ]);

        }

        $data['aktivitas'] = $aktivitas
            ->sortByDesc('waktu')
            ->take(8);

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        if ($jabatan == 'Admin') {

            return view('admin.dashboard', $data);

        }

        return view('dashboard.index', $data);
    }
}