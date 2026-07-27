<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\Surat;
use App\Models\User;

class ApprovalWorkflowService
{
    /**
     * Status awal ketika surat dikirim.
     */
    public function getInitialStatus(User $user): string
    {
        $jabatan = $user->jabatan->nama_jabatan ?? '';

        return match ($jabatan) {

            'Ketua Tim Perencana dan Pengendali Program'
                => 'Menunggu Approval KTU',

            'Kepala Sub Bagian Tata Usaha'
                => 'Menunggu Approval Kepala Stasiun',

            'Kepala TVRI Stasiun NTB'
                => 'Disetujui',

            default
                => 'Menunggu Approval KPP',
        };
    }

    /**
     * Status berikutnya.
     */
    public function getNextStatus(Surat $surat): string
    {
        return match ($surat->status) {

            'Menunggu Approval KPP'
                => 'Menunggu Approval KTU',

            'Menunggu Approval KTU'
                => 'Menunggu Approval Kepala Stasiun',

            'Menunggu Approval Kepala Stasiun'
                => 'Disetujui',

            default
                => $surat->status,
        };
    }

    /**
     * Cari approver sesuai status surat.
     */
    public function getCurrentApprover(Surat $surat): ?User
    {
        $jabatan = match ($surat->status) {

            'Menunggu Approval KPP'
                => 'Ketua Tim Perencana dan Pengendali Program',

            'Menunggu Approval KTU'
                => 'Kepala Sub Bagian Tata Usaha',

            'Menunggu Approval Kepala Stasiun'
                => 'Kepala TVRI Stasiun NTB',

            default
                => null,
        };

        if (!$jabatan) {
            return null;
        }

        return User::whereHas('jabatan', function ($q) use ($jabatan) {
            $q->where('nama_jabatan', $jabatan);
        })->first();
    }

    /**
     * Proses approval.
     */
    public function approve(Surat $surat, User $user): void
    {
        $statusBaru = $this->getNextStatus($surat);

        $surat->update([
            'status' => $statusBaru,
        ]);

        if ($statusBaru === 'Disetujui') {
            $surat->update([
                'tanggal_selesai' => now(),
            ]);
            return;
        }

        $nextApprover = $this->getCurrentApprover($surat);

        if ($nextApprover) {

            Approval::create([
                'surat_id'    => $surat->id,
                'approver_id' => $nextApprover->id,
                'urutan'      => Approval::where('surat_id', $surat->id)->count() + 1,
                'status'      => 'Menunggu',
                'catatan'     => null,
            ]);

        }
    }

    /**
     * Proses penolakan.
     */
    public function reject(Surat $surat, string $catatan = null): void
    {
        $surat->update([
            'status' => 'Ditolak',
            'catatan' => $catatan,
        ]);
    }
}