<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Surat;
use App\Services\ApprovalWorkflowService;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{

public function index()
{
    $user = auth()->user();
    $jabatan = $user->jabatan->nama_jabatan ?? '';

    $query = Surat::with([
        'pengirim',
        'tujuan.user'
    ]);

    /*
    |--------------------------------------------------------------------------
    | FILTER BERDASARKAN JABATAN
    |--------------------------------------------------------------------------
    */

    if ($jabatan == 'Admin') {

        // Admin melihat semua surat

    } elseif ($jabatan == 'Ketua Tim Perencana dan Pengendali Program') {

        $query->where('status', 'Menunggu Approval KPP');

    } elseif ($jabatan == 'Kepala Sub Bagian Tata Usaha') {

        $query->where('status', 'Menunggu Approval KTU');

    } elseif ($jabatan == 'Kepala TVRI Stasiun NTB') {

        $query->where('status', 'Menunggu Approval Kepala Stasiun');

    } else {

        $query->where('pengirim_id', $user->id);

    }

    $surat = $query->latest()->get();

    $totalSurat = $surat->count();

    $menunggu = $surat->whereIn('status', [
        'Menunggu Approval KPP',
        'Menunggu Approval KTU',
        'Menunggu Approval Kepala Stasiun'
    ])->count();

    $disetujui = $surat->where('status', 'Disetujui')->count();

    $ditolak = $surat->where('status', 'Ditolak')->count();

    return view('surat.approval', compact(
        'totalSurat',
        'menunggu',
        'disetujui',
        'ditolak',
        'surat'
    ));
}
public function approveKpp($id)
{
    $surat = Surat::findOrFail($id);

    if ($surat->status !== 'Menunggu Approval KPP') {
        return redirect()
    ->route('surat.approval')
    ->with('error', 'Status surat tidak sesuai.');
    }

    $cek = Approval::where('surat_id', $surat->id)
    ->where('urutan', 1)
    ->exists();

if ($cek) {
    return redirect()
        ->route('surat.approval')
        ->with('error', 'Surat sudah pernah diproses.');
}
DB::transaction(function () use ($surat) {
Approval::create([
    'surat_id'    => $surat->id,
    'approver_id' => auth()->id(),// sementara, nanti diganti Auth::id()
    'urutan'      => 1,
    'status'      => 'Disetujui',
    'approved_at' => now(),
]);
$workflow = new ApprovalWorkflowService();

$surat->update([
    'status' => $workflow->getNextStatus($surat)
]);
});
return redirect()
    ->route('surat.approval')
    ->with('success', 'Surat berhasil disetujui oleh KPP.');
}
public function rejectKpp($id)
{
    $surat = Surat::findOrFail($id);

    // Pastikan surat berada pada tahap approval KPP
    if ($surat->status !== 'Menunggu Approval KPP') {
        return redirect()
            ->route('surat.approval')
            ->with('error', 'Status surat tidak sesuai.');
    }

    // Cegah surat diproses lebih dari satu kali oleh KPP
    $sudahDiproses = Approval::where('surat_id', $surat->id)
        ->where('urutan', 1)
        ->exists();

    if ($sudahDiproses) {
        return redirect()
            ->route('surat.approval')
            ->with('error', 'Surat sudah pernah diproses.');
    }

    DB::transaction(function () use ($surat) {

        Approval::create([
            'surat_id'    => $surat->id,
            'approver_id' => auth()->id(),
            'urutan'      => 1,
            'status'      => 'Ditolak',
            'approved_at' => now(),
        ]);

        $surat->update([
            'status' => 'Ditolak',
        ]);
    });

    return redirect()
        ->route('surat.approval')
        ->with('success', 'Surat berhasil ditolak oleh KPP.');
}
public function approveKtu($id)
{
    $surat = Surat::findOrFail($id);

    // Validasi status
    if ($surat->status !== 'Menunggu Approval KTU') {
        return redirect()
            ->route('surat.approval')
            ->with('error', 'Status surat tidak sesuai.');
    }

    // Cek apakah sudah pernah diproses
    $cek = Approval::where('surat_id', $surat->id)
        ->where('urutan', 2)
        ->exists();

    if ($cek) {
        return redirect()
            ->route('surat.approval')
            ->with('error', 'Surat sudah pernah diproses.');
    }

    DB::transaction(function () use ($surat) {

        Approval::create([
            'surat_id'    => $surat->id,
            'approver_id' => auth()->id(),
            'urutan'      => 2,
            'status'      => 'Disetujui',
            'approved_at' => now(),
        ]);

        $workflow = new ApprovalWorkflowService();

        $surat->update([
            'status' => $workflow->getNextStatus($surat),
        ]);
    });

    return redirect()
        ->route('surat.approval')
        ->with('success', 'Surat berhasil disetujui oleh KTU.');
}
public function rejectKtu($id)
{
    $surat = Surat::findOrFail($id);

    // Validasi status
    if ($surat->status !== 'Menunggu Approval KTU') {
        return redirect()
            ->route('surat.approval')
            ->with('error', 'Status surat tidak sesuai.');
    }

    // Cek apakah sudah pernah diproses
    $cek = Approval::where('surat_id', $surat->id)
        ->where('urutan', 2)
        ->exists();

    if ($cek) {
        return redirect()
            ->route('surat.approval')
            ->with('error', 'Surat sudah pernah diproses.');
    }

    DB::transaction(function () use ($surat) {

        Approval::create([
            'surat_id'    => $surat->id,
            'approver_id' => auth()->id(),
            'urutan'      => 2,
            'status'      => 'Ditolak',
            'approved_at' => now(),
        ]);

        $surat->update([
            'status' => 'Ditolak',
        ]);
    });

    return redirect()
        ->route('surat.approval')
        ->with('success', 'Surat berhasil ditolak oleh KTU.');
}
public function approveKepalaStasiun($id)
{
    $surat = Surat::findOrFail($id);

    // Validasi status
    if ($surat->status !== 'Menunggu Approval Kepala Stasiun') {
        return redirect()
            ->route('surat.approval')
            ->with('error', 'Status surat tidak sesuai.');
    }

    // Cek apakah sudah pernah diproses
    $cek = Approval::where('surat_id', $surat->id)
        ->where('urutan', 3)
        ->exists();

    if ($cek) {
        return redirect()
            ->route('surat.approval')
            ->with('error', 'Surat sudah pernah diproses.');
    }

    DB::transaction(function () use ($surat) {

        Approval::create([
            'surat_id'    => $surat->id,
            'approver_id' => auth()->id(),
            'urutan'      => 3,
            'status'      => 'Disetujui',
            'approved_at' => now(),
        ]);

        $workflow = new ApprovalWorkflowService();

        $surat->update([
            'status' => $workflow->getNextStatus($surat),
        ]);
    });

    return redirect()
        ->route('surat.approval')
        ->with('success', 'Surat berhasil disetujui oleh Kepala Stasiun.');
}

public function rejectKepalaStasiun($id)
{
    $surat = Surat::findOrFail($id);

    // Validasi status
    if ($surat->status !== 'Menunggu Approval Kepala Stasiun') {
        return redirect()
            ->route('surat.approval')
            ->with('error', 'Status surat tidak sesuai.');
    }

    // Cek apakah sudah pernah diproses
    $cek = Approval::where('surat_id', $surat->id)
        ->where('urutan', 3)
        ->exists();

    if ($cek) {
        return redirect()
            ->route('surat.approval')
            ->with('error', 'Surat sudah pernah diproses.');
    }

    DB::transaction(function () use ($surat) {

        Approval::create([
            'surat_id'    => $surat->id,
            'approver_id' => auth()->id(),
            'urutan'      => 3,
            'status'      => 'Ditolak',
            'approved_at' => now(),
        ]);

        $surat->update([
            'status' => 'Ditolak',
        ]);
    });

    return redirect()
        ->route('surat.approval')
        ->with('success', 'Surat berhasil ditolak oleh Kepala Stasiun.');
}
}