<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\ApprovalWorkflow;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;


class ApprovalWorkflowService
{
    /**
     * Mengambil seluruh workflow berdasarkan jenis surat.
     */
    public function getWorkflow(
    Surat $surat
    ): Collection
    {
        return ApprovalWorkflow::with('jabatan')
            ->where('jenis_surat_id', $surat->jenis_surat_id)
            ->where('aktif', true)
            ->orderBy('urutan')
            ->get();
    }

    /**
     * Langkah pertama approval.
     */
    /**
/**
 * Workflow pertama yang harus diproses.
 * Akan melewati jabatan pengirim.
 */
public function getFirstAvailableStep(
    Surat $surat
): ?ApprovalWorkflow
{
    $pengirim = $surat->pengirim;

    if (!$pengirim) {
        throw new \Exception(
            'Pengirim surat tidak ditemukan.'
        );
    }

    return $this->getWorkflow($surat)
        ->first(function ($workflow) use ($pengirim) {

            return $workflow->jabatan_id !== $pengirim->jabatan_id;

        });
}
/**
 * Workflow berikutnya.
 * Akan melewati jabatan pengirim.
 */
public function getNextAvailableStep(
    Surat $surat,
    ApprovalWorkflow $currentWorkflow
): ?ApprovalWorkflow
{
    $pengirim = $surat->pengirim;

    if (!$pengirim) {
        throw new \Exception(
            'Pengirim surat tidak ditemukan.'
        );
    }

    return $this->getWorkflow($surat)

        ->where(
            'urutan',
            '>',
            $currentWorkflow->urutan
        )

        ->first(function ($workflow) use ($pengirim) {

            return $workflow->jabatan_id !== $pengirim->jabatan_id;

        });
}
    /**
     * Cari user berdasarkan jabatan.
     */
    public function getApproverByStep(ApprovalWorkflow $step): ?User
    {
        return User::where('jabatan_id', $step->jabatan_id)
            ->where('is_active', true)
            ->first();
    }

        /**
     * Approval yang sedang aktif.
     */
    public function getCurrentApproval(
        Surat $surat,
        User $user
    ): ?Approval
    {
        return Approval::where('surat_id', $surat->id)
            ->where('approver_id', $user->id)
            ->where('status', 'Menunggu')
            ->first();
    }

        /**
     * Menyelesaikan workflow.
     */
    private function finishWorkflow(Surat $surat): void
    {
        $surat->update([
            'status'            => 'Disetujui',
            'tanggal_selesai'   => now(),
        ]);
    }

    /**
 * Proses approval surat.
 */
/**
 * Proses approval surat.
 */
public function approve(
    Surat $surat,
    User $user
): void
{
    // Cari approval aktif milik user
    $approval = $this->getCurrentApproval(
        $surat,
        $user
    );

    if (!$approval) {
        throw new \Exception(
            'Approval tidak ditemukan atau sudah diproses.'
        );
    }

    // Update approval menjadi disetujui
    $approval->update([
        'status'      => 'Disetujui',
        'approved_at' => now(),
        'catatan'     => 'Disetujui',
    ]);

    // Ambil workflow yang sedang berjalan
    $currentWorkflow = $approval->workflow;

    if (!$currentWorkflow) {
        throw new \Exception(
            'Workflow approval tidak ditemukan.'
        );
    }

    // Cari workflow berikutnya
    $nextStep = $this->getNextAvailableStep(
        $surat,
        $currentWorkflow
    );

    // Jika tidak ada workflow berikutnya,
    // maka surat selesai
    if (!$nextStep) {

        $this->finishWorkflow($surat);

        return;
    }

    // Buat approval berikutnya
    $this->createApproval(
        $surat,
        $nextStep
    );

    // Update status surat
        $surat->update([
        'status' => 'Menunggu Approval ' . $nextStep->jabatan->nama_jabatan,
    ]);
}
/**
 * Membuat satu record approval.
 */
private function createApproval(
    Surat $surat,
    ApprovalWorkflow $workflow
): void
{
    $approver = $this->getApproverByStep($workflow);

    if (!$approver) {
        throw new \Exception(
            'Approver untuk jabatan "' .
            $workflow->jabatan->nama_jabatan .
            '" tidak ditemukan.'
        );
    }

    if ($approver->id === $surat->pengirim_id) {
        throw new \Exception(
            'Pengirim tidak boleh menjadi approver.'
        );
    }

    Approval::create([
        'surat_id'             => $surat->id,
        'approval_workflow_id' => $workflow->id,
        'approver_id'          => $approver->id,
        'urutan'               => $workflow->urutan,
        'status'               => 'Menunggu',
        'catatan'              => null,
        'approved_at'          => null,
    ]);
}

/**
 * Membuat approval pertama berdasarkan workflow.
 */
public function createFirstApproval(
    Surat $surat
): void
{
    // Cegah approval ganda
    if (Approval::where('surat_id', $surat->id)->exists()) {
        return;
    }

    // Pastikan workflow tersedia
    $workflow = $this->getWorkflow($surat);

    if ($workflow->isEmpty()) {
        throw new \Exception(
            'Workflow approval belum dikonfigurasi untuk jenis surat ini.'
        );
    }

    // Cari approver pertama
    $step = $this->getFirstAvailableStep($surat);

    /*
    |--------------------------------------------------------------------------
    | Pengirim adalah approver terakhir
    |--------------------------------------------------------------------------
    */

    if (!$step) {

        $this->finishWorkflow($surat);

        return;

    }

    // Buat approval pertama
    $this->createApproval(
        $surat,
        $step
    );

    // Update status surat
        $surat->update([
        'status' => 'Menunggu Approval ' . $step->jabatan->nama_jabatan,
        'tanggal_kirim' => now(),
    ]);
}
}