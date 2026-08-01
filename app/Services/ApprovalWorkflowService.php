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
    public function getFirstStep(
    Surat $surat
    ): ?ApprovalWorkflow
    {
        return $this->getWorkflow($surat)->first();
    }

    /**
     * Langkah berikutnya.
     */
    public function getNextStep(
        Surat $surat,
        ApprovalWorkflow $currentWorkflow
    ): ?ApprovalWorkflow
    {
        return ApprovalWorkflow::with('jabatan')
            ->where('jenis_surat_id', $surat->jenis_surat_id)
            ->where('aktif', true)
            ->where('urutan', '>', $currentWorkflow->urutan)
            ->orderBy('urutan')
            ->first();
    }

    /**
     * Cari user berdasarkan jabatan.
     */
    public function getApproverByStep(ApprovalWorkflow $step): ?User
    {
        return User::where('jabatan_id', $step->jabatan_id)
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
    $nextStep = $this->getNextStep(
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
        'status' => 'Menunggu Approval',
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
public function createFirstApproval(Surat $surat): void
{
    // Cegah approval ganda
    if (Approval::where('surat_id', $surat->id)->exists()) {
        return;
    }

    // Ambil workflow pertama
    $step = $this->getFirstStep($surat);

    if (!$step) {
        throw new \Exception(
            'Workflow approval belum dikonfigurasi untuk jenis surat ini.'
        );
    }

    // Buat approval pertama
    $this->createApproval(
        $surat,
        $step
    );

    // Update status surat
    $surat->update([
        'status'        => 'Menunggu Approval',
        'tanggal_kirim' => now(),
    ]);
}
}