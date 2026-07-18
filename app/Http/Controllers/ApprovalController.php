<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Surat;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
public function approveKpp($id)
{
    $surat = Surat::find($id);

    if (!$surat) {
        return response()->json([
            'success' => false,
            'message' => 'Surat tidak ditemukan.'
        ], 404);
    }

    if ($surat->status !== 'Menunggu Verifikasi KPP') {
        return response()->json([
            'success' => false,
            'message' => 'Status surat tidak sesuai.'
        ], 400);
    }
Approval::create([
    'surat_id'    => $surat->id,
    'approver_id' => 2, // sementara, nanti diganti Auth::id()
    'urutan'      => 1,
    'status'      => 'Disetujui',
    'approved_at' => now(),
]);
    $surat->status = 'Menunggu Paraf KTU';
    $surat->save();

    return response()->json([
        'success' => true,
        'message' => 'Surat berhasil diverifikasi KPP.',
        'data' => $surat
    ]);
}
public function rejectKpp($id)
{
    $surat = Surat::find($id);

    if (!$surat) {
        return response()->json([
            'success' => false,
            'message' => 'Surat tidak ditemukan.'
        ], 404);
    }
    Approval::create([
    'surat_id'    => $surat->id,
    'approver_id' => 2,
    'urutan'      => 1,
    'status'      => 'Ditolak',
    'approved_at' => now(),
]);

    $surat->status = 'Ditolak';

    $surat->save();

    return response()->json([
        'success' => true,
        'message' => 'Surat ditolak oleh KPP.',
        'data' => $surat
    ]);
    
}
public function approveKtu($id)
{
    $surat = Surat::find($id);

    if (!$surat) {
        return response()->json([
            'success' => false,
            'message' => 'Surat tidak ditemukan.'
        ], 404);
    }

    if ($surat->status !== 'Menunggu Paraf KTU') {
        return response()->json([
            'success' => false,
            'message' => 'Status surat tidak sesuai.'
        ], 400);
    }
Approval::create([
    'surat_id'    => $surat->id,
    'approver_id' => 3,
    'urutan'      => 2,
    'status'      => 'Disetujui',
    'approved_at' => now(),
]);
    $surat->status = 'Menunggu Persetujuan Kepala Stasiun';

    $surat->save();

    return response()->json([
        'success' => true,
        'message' => 'Paraf KTU berhasil.',
        'data' => $surat
    ]);
}
public function rejectKtu($id)
{
    $surat = Surat::find($id);

    if (!$surat) {
        return response()->json([
            'success' => false,
            'message' => 'Surat tidak ditemukan.'
        ], 404);
    }
Approval::create([
    'surat_id'    => $surat->id,
    'approver_id' => 3,
    'urutan'      => 2,
    'status'      => 'Ditolak',
    'approved_at' => now(),
]);
    $surat->status = 'Ditolak';

    $surat->save();

    return response()->json([
        'success' => true,
        'message' => 'Surat ditolak oleh KTU.',
        'data' => $surat
    ]);
}
public function approveKepalaStasiun($id)
{
    $surat = Surat::find($id);

    if (!$surat) {
        return response()->json([
            'success' => false,
            'message' => 'Surat tidak ditemukan.'
        ], 404);
    }

    if ($surat->status !== 'Menunggu Persetujuan Kepala Stasiun') {
        return response()->json([
            'success' => false,
            'message' => 'Status surat tidak sesuai.'
        ], 400);
    }
Approval::create([
    'surat_id'    => $surat->id,
    'approver_id' => 4,
    'urutan'      => 3,
    'status'      => 'Disetujui',
    'approved_at' => now(),
]);
    $surat->status = 'Disetujui';

    $surat->save();

    return response()->json([
        'success' => true,
        'message' => 'Surat disetujui Kepala Stasiun.',
        'data' => $surat
    ]);
}
public function rejectKepalaStasiun($id)
{
    $surat = Surat::find($id);

    if (!$surat) {
        return response()->json([
            'success' => false,
            'message' => 'Surat tidak ditemukan.'
        ], 404);
    }
Approval::create([
    'surat_id'    => $surat->id,
    'approver_id' => 4,
    'urutan'      => 3,
    'status'      => 'Ditolak',
    'approved_at' => now(),
]);
    $surat->status = 'Ditolak';

    $surat->save();

    return response()->json([
        'success' => true,
        'message' => 'Surat ditolak oleh Kepala Stasiun.',
        'data' => $surat
    ]);
}
}