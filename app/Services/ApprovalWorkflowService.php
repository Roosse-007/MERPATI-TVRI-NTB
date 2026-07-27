<?php

namespace App\Services;

use App\Models\Surat;
use App\Models\User;

class ApprovalWorkflowService
{
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
}