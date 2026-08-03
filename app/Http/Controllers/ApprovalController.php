<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Surat;
use App\Services\ApprovalWorkflowService;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    protected ApprovalWorkflowService $workflowService;

    public function __construct(
        ApprovalWorkflowService $workflowService
    ) {
        $this->workflowService = $workflowService;
    }

    /**
     * Halaman Approval
     */
    public function index(Request $request)
    {
        $query = Surat::with([

            'pengirim.jabatan',

            'tujuan.user',

            'jenisSurat',

            'jenisSurat.approvalWorkflows.jabatan',

            'approval.workflow.jabatan',

            'approval.approver',

        ])
        ->whereHas('approval', function ($query) {

            $query->where('approver_id', auth()->id())
                ->where('status', 'Menunggu');

        });

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%");

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Filter Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Ambil Data
        |--------------------------------------------------------------------------
        */

        $surat = $query
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Statistik Approval User Login
        |--------------------------------------------------------------------------
        */

        $totalSurat = Approval::where(
            'approver_id',
            auth()->id()
        )
        ->distinct('surat_id')
        ->count('surat_id');

        $menunggu = Approval::where(
            'approver_id',
            auth()->id()
        )
        ->where(
            'status',
            'Menunggu'
        )
        ->count();

        $disetujui = Approval::where(
            'approver_id',
            auth()->id()
        )
        ->where(
            'status',
            'Disetujui'
        )
        ->count();

        $ditolak = Approval::where(
            'approver_id',
            auth()->id()
        )
        ->where(
            'status',
            'Ditolak'
        )
        ->count();

        return view(
            'surat.approval',
            compact(
                'surat',
                'totalSurat',
                'menunggu',
                'disetujui',
                'ditolak'
            )
        );
    }

    /**
     * Approve Surat
     */
    public function approve(
        Surat $surat
    ) {
        $this->workflowService->approve(
            $surat,
            auth()->user()
        );

        return redirect()
            ->route('surat.approval')
            ->with(
                'success',
                'Surat berhasil disetujui.'
            );
    }

    /**
     * Reject Surat
     */
    public function reject(
        Request $request,
        Surat $surat
    ) {
        $request->validate([

            'catatan' => [
                'nullable',
                'string',
                'max:500',
            ],

        ]);

        $this->workflowService->reject(

            $surat,

            auth()->user(),

            $request->catatan

        );

        return redirect()
            ->route('surat.approval')
            ->with(
                'success',
                'Surat berhasil ditolak.'
            );
    }
}