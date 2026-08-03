<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Support\Facades\Storage;

class TerkirimController extends Controller
{
    /**
     * Halaman Surat Terkirim
     */
    public function index()
    {
        $surat = Surat::with([
                'pengirim',
                'tujuan.user',
                'jenisSurat',
                'sifatSurat'
                //'prioritasSurat',
            ])
            ->where('pengirim_id', auth()->id())
            ->where('status', '!=', 'Draft')
            ->latest()
            ->paginate(10);

        return view('surat.terkirim', compact('surat'));
    }

    /**
     * Lihat File Surat
     */
    public function show($id)
    {
        $surat = Surat::where('id', $id)
        ->where('pengirim_id', auth()->id())
        ->firstOrFail();

        // Tidak ada file
        if (empty($surat->file_surat)) {

            return redirect()
                ->route('surat.terkirim')
                ->with('error', 'Surat ini belum memiliki lampiran.');

        }

        // File tidak ditemukan
        if (!Storage::disk('public')->exists($surat->file_surat)) {

            return redirect()
                ->route('surat.terkirim')
                ->with('error', 'File surat tidak ditemukan di server.');

        }

        // Tampilkan file di browser
        return response()->file(
            storage_path('app/public/' . $surat->file_surat)
        );
    }


    /**
     * Tracking Surat
     */
    public function tracking($id)
    {
    $surat = Surat::with([
        'pengirim',
        'jenisSurat',
        'jenisSurat.approvalWorkflows.jabatan',
        'sifatSurat',
        'tujuan.user',
        'approval.approver',
        'approval.workflow.jabatan',
        'arsip',
        'disposisi',
    ])
    ->where('id', $id)
    ->where('pengirim_id', auth()->id())
    ->firstOrFail();

        $timeline = [];

        /*
        |--------------------------------------------------------------------------
        | Draft
        |--------------------------------------------------------------------------
        */

        $timeline[] = [
            'judul'    => 'Draft Dibuat',
            'status'   => 'Selesai',
            'icon'     => 'check',
            'warna'    => 'green',
            'waktu'    => $surat->created_at,
            'catatan'  => null,
        ];

        /*
        |--------------------------------------------------------------------------
        | Surat Dikirim
        |--------------------------------------------------------------------------
        */

        if ($surat->tanggal_kirim) {

            $timeline[] = [
                'judul'    => 'Surat Dikirim',
                'status'   => 'Selesai',
                'icon'     => 'send',
                'warna'    => 'blue',
                'waktu'    => $surat->tanggal_kirim,
                'catatan'  => null,
            ];
        }

       /*
/*
|--------------------------------------------------------------------------
| Approval Workflow (Dinamis)
|--------------------------------------------------------------------------
*/

$workflows = $surat->jenisSurat
    ->approvalWorkflows;

foreach ($workflows as $workflow) {

    $approval = $surat->approval
        ->firstWhere(
            'approval_workflow_id',
            $workflow->id
        );

    /*
    |--------------------------------------------------------------------------
    | Jabatan Pengirim
    |--------------------------------------------------------------------------
    */

    if (
        $workflow->jabatan_id ==
        $surat->pengirim->jabatan_id
    ) {

        $timeline[] = [

            'judul'   => $workflow->jabatan->nama_jabatan,

            'status'  => 'Disetujui',

            'icon'    => 'check',

            'warna'   => 'green',

            'waktu'   => $surat->tanggal_kirim,

            'catatan' => 'Membuat dan mengirim surat',

        ];

        continue;

    }

    /*
    |--------------------------------------------------------------------------
    | Approval Ada
    |--------------------------------------------------------------------------
    */

    if ($approval) {

        $timeline[] = [

            'judul'   => $workflow->jabatan->nama_jabatan,

            'status'  => $approval->status,

            'icon'    => $approval->icon,

            'warna'   => $approval->badge_color,

            'waktu'   => $approval->approved_at,

            'catatan' => $approval->catatan,

        ];

    }

    /*
    |--------------------------------------------------------------------------
    | Belum Diproses
    |--------------------------------------------------------------------------
    */

    else {

        $timeline[] = [

            'judul'   => $workflow->jabatan->nama_jabatan,

            'status'  => 'Belum Diproses',

            'icon'    => 'circle',

            'warna'   => 'gray',

            'waktu'   => null,

            'catatan' => null,

        ];

    }

}

/*
|--------------------------------------------------------------------------
| Surat Disetujui
|--------------------------------------------------------------------------
*/

if ($surat->status === 'Disetujui') {

    $timeline[] = [

        'judul'   => 'Surat Disetujui',

        'status'  => 'Disetujui',

        'icon'    => 'flag',

        'warna'   => 'green',

        'waktu'   => $surat->tanggal_selesai,

        'catatan' => null,

    ];

}

        /*
        |--------------------------------------------------------------------------
        | Surat Ditolak
        |--------------------------------------------------------------------------
        */

        if ($surat->status === 'Ditolak') {

            $timeline[] = [

                'judul' => 'Surat Ditolak',

                'status' => 'Ditolak',

                'icon' => 'x-circle',

                'warna' => 'red',

                'waktu' => $surat->tanggal_selesai,

                'catatan' => $surat->catatan,

            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Arsip
        |--------------------------------------------------------------------------
        */

        if ($surat->arsip) {

            $timeline[] = [

                'judul' => 'Surat Diarsipkan',

                'status' => 'Arsip',

                'icon' => 'archive',

                'warna' => 'gray',

                'waktu' => $surat->arsip->created_at,

                'catatan' => null,

            ];
        }

        return view(
            'surat.tracking',
            compact(
                'surat',
                'timeline'
            )
        );
    }
}