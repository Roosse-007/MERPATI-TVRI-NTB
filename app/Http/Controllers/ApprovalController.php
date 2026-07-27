<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Surat;
use App\Services\ApprovalWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    /**
     * Halaman Approval Surat
     */
public function index()
{
    $user = auth()->user();
    $jabatan = $user->jabatan->nama_jabatan ?? '';

    $query = Surat::with([
        'pengirim.jabatan',
        'tujuan.user',
        'approval'
    ])
    // HANYA surat yang ditujukan ke akun login
    ->whereHas('tujuan', function ($q) use ($user) {
        $q->where('user_id', $user->id);
    });

    switch ($jabatan) {

        case 'Admin':
            // Admin melihat semua surat yang ditujukan kepadanya
            break;

        case 'Ketua Tim Perencana dan Pengendali Program':
            $query->where('status', 'Menunggu Approval KPP');
            break;

        case 'Kepala Sub Bagian Tata Usaha':
            $query->where('status', 'Menunggu Approval KTU');
            break;

        case 'Kepala TVRI Stasiun NTB':
            $query->where('status', 'Menunggu Approval Kepala Stasiun');
            break;

        default:
            // Jabatan lain tidak mempunyai halaman approval
            $query->whereRaw('1 = 0');
            break;
    }

    $surat = $query->latest()->get();

    $totalSurat = $surat->count();

    $menunggu = $surat->whereIn('status', [
        'Menunggu Approval KPP',
        'Menunggu Approval KTU',
        'Menunggu Approval Kepala Stasiun',
    ])->count();

    $disetujui = $surat->where('status', 'Disetujui')->count();

    $ditolak = $surat->where('status', 'Ditolak')->count();

    return view('surat.approval', compact(
        'surat',
        'totalSurat',
        'menunggu',
        'disetujui',
        'ditolak'
    ));
}
        /**
     * Mengecek apakah user memiliki hak approval
     */
    private function checkRole(string $jabatan)
    {
        $userJabatan = auth()->user()->jabatan->nama_jabatan ?? '';

        if ($userJabatan !== $jabatan) {
            abort(403, 'Anda tidak memiliki hak untuk melakukan approval.');
        }
    }

    /**
     * Mengecek status surat
     */
    private function checkStatus(Surat $surat, string $status)
    {
        if ($surat->status !== $status) {
            return redirect()
                ->route('surat.approval')
                ->with('error', 'Status surat tidak sesuai.');
        }

        return null;
    }

    /**
     * Mengecek apakah approval sudah pernah dilakukan
     */
    private function checkApproval(Surat $surat, int $urutan)
    {
        $cek = Approval::where('surat_id', $surat->id)
            ->where('urutan', $urutan)
            ->exists();

        if ($cek) {
            return redirect()
                ->route('surat.approval')
                ->with('error', 'Surat sudah pernah diproses.');
        }

        return null;
    }

    /**
     * Menyimpan data approval
     */
    private function createApproval(
        Surat $surat,
        int $urutan,
        string $status,
        ?string $catatan = null
    ) {
        Approval::create([
            'surat_id'    => $surat->id,
            'approver_id' => auth()->id(),
            'urutan'      => $urutan,
            'status'      => $status,
            'catatan'     => $catatan,
            'approved_at' => now(),
        ]);
    }

    /**
     * Mengubah status surat ke tahap berikutnya
     */
    private function nextStatus(Surat $surat)
    {
        $workflow = new ApprovalWorkflowService();

        $surat->update([
            'status' => $workflow->getNextStatus($surat),
        ]);
    }
        /**
     * Approval oleh KPP
     */
    public function approveKpp($id)
    {
        // Hanya KPP yang boleh approve
        $this->checkRole('Ketua Tim Perencana dan Pengendali Program');

        $surat = Surat::findOrFail($id);

        // Cek status surat
        if ($error = $this->checkStatus($surat, 'Menunggu Approval KPP')) {
            return $error;
        }

        // Cek apakah sudah pernah diproses
        if ($error = $this->checkApproval($surat, 1)) {
            return $error;
        }

        DB::transaction(function () use ($surat) {

            // Simpan approval
            $this->createApproval(
                $surat,
                1,
                'Disetujui'
            );

            // Lanjut ke approval berikutnya
            $this->nextStatus($surat);

        });

        return redirect()
            ->route('surat.approval')
            ->with('success', 'Surat berhasil disetujui oleh KPP.');
    }
        /**
     * Penolakan oleh KPP
     */
    public function rejectKpp(Request $request, $id)
    {
        // Hanya KPP yang boleh menolak
        $this->checkRole('Ketua Tim Perencana dan Pengendali Program');

        $surat = Surat::findOrFail($id);

        // Cek status surat
        if ($error = $this->checkStatus($surat, 'Menunggu Approval KPP')) {
            return $error;
        }

        // Cek apakah sudah pernah diproses
        if ($error = $this->checkApproval($surat, 1)) {
            return $error;
        }

        DB::transaction(function () use ($surat, $request) {

            // Simpan approval
            $this->createApproval(
                $surat,
                1,
                'Ditolak',
                $request->catatan
            );

            // Update status surat
            $surat->update([
                'status'   => 'Ditolak',
                'catatan'  => $request->catatan,
            ]);

        });

        return redirect()
            ->route('surat.approval')
            ->with('success', 'Surat berhasil ditolak oleh KPP.');
    }
        /**
     * Approval oleh KTU
     */
    public function approveKtu($id)
    {
        // Hanya KTU yang boleh approve
        $this->checkRole('Kepala Sub Bagian Tata Usaha');

        $surat = Surat::findOrFail($id);

        // Cek status surat
        if ($error = $this->checkStatus($surat, 'Menunggu Approval KTU')) {
            return $error;
        }

        // Cek apakah sudah pernah diproses
        if ($error = $this->checkApproval($surat, 2)) {
            return $error;
        }

        DB::transaction(function () use ($surat) {

            // Simpan approval
            $this->createApproval(
                $surat,
                2,
                'Disetujui'
            );

            // Lanjut ke approval berikutnya
            $this->nextStatus($surat);

        });

        return redirect()
            ->route('surat.approval')
            ->with('success', 'Surat berhasil disetujui oleh KTU.');
    }
        /**
     * Penolakan oleh KTU
     */
    public function rejectKtu(Request $request, $id)
    {
        // Hanya KTU yang boleh menolak
        $this->checkRole('Kepala Sub Bagian Tata Usaha');

        $surat = Surat::findOrFail($id);

        // Cek status surat
        if ($error = $this->checkStatus($surat, 'Menunggu Approval KTU')) {
            return $error;
        }

        // Cek apakah sudah pernah diproses
        if ($error = $this->checkApproval($surat, 2)) {
            return $error;
        }

        DB::transaction(function () use ($surat, $request) {

            // Simpan approval
            $this->createApproval(
                $surat,
                2,
                'Ditolak',
                $request->catatan
            );

            // Update status surat
            $surat->update([
                'status'   => 'Ditolak',
                'catatan'  => $request->catatan,
            ]);

        });

        return redirect()
            ->route('surat.approval')
            ->with('success', 'Surat berhasil ditolak oleh KTU.');
    }
        /**
     * Approval oleh Kepala TVRI
     */
    public function approveKepalaStasiun($id)
    {
        // Hanya Kepala TVRI yang boleh approve
        $this->checkRole('Kepala TVRI Stasiun NTB');

        $surat = Surat::findOrFail($id);

        // Cek status surat
        if ($error = $this->checkStatus($surat, 'Menunggu Approval Kepala Stasiun')) {
            return $error;
        }

        // Cek apakah sudah pernah diproses
        if ($error = $this->checkApproval($surat, 3)) {
            return $error;
        }

        DB::transaction(function () use ($surat) {

            // Simpan approval
            $this->createApproval(
                $surat,
                3,
                'Disetujui'
            );

            // Ubah status menjadi Disetujui
            $this->nextStatus($surat);

        });

        return redirect()
            ->route('surat.approval')
            ->with('success', 'Surat berhasil disetujui oleh Kepala TVRI.');
    }
        /**
     * Penolakan oleh Kepala TVRI
     */
    public function rejectKepalaStasiun(Request $request, $id)
    {
        // Hanya Kepala TVRI yang boleh menolak
        $this->checkRole('Kepala TVRI Stasiun NTB');

        $surat = Surat::findOrFail($id);

        // Cek status surat
        if ($error = $this->checkStatus($surat, 'Menunggu Approval Kepala Stasiun')) {
            return $error;
        }

        // Cek apakah sudah pernah diproses
        if ($error = $this->checkApproval($surat, 3)) {
            return $error;
        }

        DB::transaction(function () use ($surat, $request) {

            // Simpan approval
            $this->createApproval(
                $surat,
                3,
                'Ditolak',
                $request->catatan
            );

            // Update status surat
            $surat->update([
                'status'   => 'Ditolak',
                'catatan'  => $request->catatan,
            ]);

        });

        return redirect()
            ->route('surat.approval')
            ->with('success', 'Surat berhasil ditolak oleh Kepala TVRI.');
    }
}