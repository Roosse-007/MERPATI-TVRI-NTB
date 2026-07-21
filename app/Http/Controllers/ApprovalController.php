<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{

public function index()
{
    $approvalDisetujui = Approval::where('status', 'Disetujui')->count();
    $approvalDitolak   = Approval::where('status', 'Ditolak')->count();
    $approvalDiproses  = Approval::whereIn('status', ['Disetujui', 'Ditolak'])->count();
    $totalSurat = Surat::count();

    $menunggu = Surat::whereIn('status', [
    'Menunggu Approval KPP',
    'Menunggu Approval KTU',
    'Menunggu Approval Kepala Stasiun'
])->count();

    $disetujui = Surat::where('status', 'Disetujui')->count();

    $ditolak = Surat::where('status', 'Ditolak')->count();

    $surat = Surat::with([
        'pengirim',
        'tujuan.user'
    ])->latest()->get();

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

    if (!$surat) {
        return redirect()
    ->route('surat.approval')
    ->with('error', 'Surat tidak ditemukan.');
    }

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
    $surat->update([
    'status' => 'Menunggu Approval KTU'
]);
});
return redirect()
    ->route('surat.approval')
    ->with('success', 'Surat berhasil disetujui oleh KPP.');
}
public function rejectKpp($id)
{
   $surat = Surat::findOrFail($id);

    if (!$surat) {
        return redirect()
    ->route('surat.approval')
    ->with('error', 'Surat tidak ditemukan.');
    }
    DB::transaction(function () use ($surat) {
    Approval::create([
    'surat_id'    => $surat->id,
    'approver_id' => auth()->id(),
    'urutan'      => 1,
    'status'      => 'Ditolak',
    'approved_at' => now(),
]);
    });
    $surat->update([
    'status' => 'Ditolak'
]);

return redirect()
    ->route('surat.approval')
    ->with('success', 'Surat ditolak oleh KPP.');
    
}
public function approveKtu($id)
{
    $surat = Surat::findOrFail($id);

    if (!$surat) {
        return redirect()
    ->route('surat.approval')
    ->with('error', 'Surat tidak ditemukan.');
    }

    if ($surat->status !== 'Menunggu Approval KTU') {
       return redirect()
    ->route('surat.approval')
    ->with('error', 'Status surat tidak sesuai.');
    }
    DB::transaction(function () use ($surat) {
Approval::create([
    'surat_id'    => $surat->id,
    'approver_id' => auth()->id(),
    'urutan'      => 2,
    'status'      => 'Disetujui',
    'approved_at' => now(),
]);
    $surat->update([
    'status' => 'Menunggu Approval Kepala Stasiun'
]);
    });
return redirect()
    ->route('surat.approval')
    ->with('success', 'Paraf KTU berhasil.');
}
public function rejectKtu($id)
{
    $surat = Surat::findOrFail($id);

    if (!$surat) {
        return redirect()
    ->route('surat.approval')
    ->with('error', 'Surat tidak ditemukan.');
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
    'status' => 'Ditolak'
]);
    });
return redirect()
    ->route('surat.approval')
    ->with('success', 'Surat berhasil disetujui oleh KTU.');
}
public function approveKepalaStasiun($id)
{
    $surat = Surat::findOrFail($id);

    if (!$surat) {
       return redirect()
    ->route('surat.approval')
    ->with('error', 'Surat tidak ditemukan.');
    }

    if ($surat->status !== 'Menunggu Approval Kepala Stasiun') {
        return redirect()
    ->route('surat.approval')
    ->with('error', 'Status surat tidak sesuai.');
    }
    DB::transaction(function () use ($surat) {
Approval::create([
    'surat_id'    => $surat->id,
    'approver_id' => auth()->id(),
    'urutan'      => 3,
    'status'      => 'Disetujui',
    'approved_at' => now(),
]);
   $surat->update([
    'status' => 'Disetujui'
]);
    });
return redirect()
    ->route('surat.approval')
    ->with('success', 'Surat disetujui Kepala Stasiun.');
}
public function rejectKepalaStasiun($id)
{
    $surat = Surat::findOrFail($id);

    if (!$surat) {
        return redirect()
    ->route('surat.approval')
    ->with('error', 'Surat tidak ditemukan.');
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
    'status' => 'Ditolak'
]);
    });
return redirect()
    ->route('surat.approval')
    ->with('success', 'Surat ditolak oleh Kepala Stasiun.');
}
}