<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ApprovalController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | HALAMAN APPROVAL
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $totalSurat = Surat::count();



        $menunggu = Surat::whereIn('status',[

            'Menunggu Verifikasi KPP',

            'Menunggu Paraf KTU',

            'Menunggu Persetujuan Kepala Stasiun'

        ])->count();



        $disetujui = Surat::where(

            'status',

            'Disetujui'

        )->count();



        $ditolak = Surat::where(

            'status',

            'Ditolak'

        )->count();





        $surat = Surat::with([

            'pengirim',

            'tujuan.user',

            'approvals.approver'

        ])

        ->whereIn('status',[

            'Menunggu Verifikasi KPP',

            'Menunggu Paraf KTU',

            'Menunggu Persetujuan Kepala Stasiun'

        ])

        ->latest()

        ->get();





        return view(

            'surat.approval',

            compact(

                'totalSurat',

                'menunggu',

                'disetujui',

                'ditolak',

                'surat'

            )

        );

    }








    /*
    |--------------------------------------------------------------------------
    | APPROVAL KPP
    |--------------------------------------------------------------------------
    */

    public function approveKpp($id)
    {

        $surat = Surat::findOrFail($id);



        if($surat->status !== 'Menunggu Verifikasi KPP')
        {

            return back()->with(

                'error',

                'Status surat tidak sesuai.'

            );

        }




        Approval::create([

            'surat_id'=>$surat->id,

            'approver_id'=>Auth::id(),

            'urutan'=>1,

            'status'=>'Disetujui',

            'approved_at'=>now()

        ]);





        $surat->update([

            'status'=>'Menunggu Paraf KTU'

        ]);





        return back()->with(

            'success',

            'Surat berhasil diverifikasi KPP.'

        );

    }








    public function rejectKpp(Request $request,$id)
    {


        $surat = Surat::findOrFail($id);



        Approval::create([

            'surat_id'=>$surat->id,

            'approver_id'=>Auth::id(),

            'urutan'=>1,

            'status'=>'Ditolak',

            'catatan'=>$request->catatan,

            'approved_at'=>now()

        ]);





        $surat->update([

            'status'=>'Ditolak',

            'catatan'=>$request->catatan

        ]);





        return back()->with(

            'success',

            'Surat ditolak KPP.'

        );

    }









    /*
    |--------------------------------------------------------------------------
    | APPROVAL KTU
    |--------------------------------------------------------------------------
    */

    public function approveKtu($id)
    {

        $surat = Surat::findOrFail($id);



        if($surat->status !== 'Menunggu Paraf KTU')
        {

            return back()->with(

                'error',

                'Status surat tidak sesuai.'

            );

        }





        Approval::create([

            'surat_id'=>$surat->id,

            'approver_id'=>Auth::id(),

            'urutan'=>2,

            'status'=>'Disetujui',

            'approved_at'=>now()

        ]);






        $surat->update([

            'status'=>'Menunggu Persetujuan Kepala Stasiun'

        ]);





        return back()->with(

            'success',

            'Paraf KTU berhasil.'

        );

    }







    public function rejectKtu(Request $request,$id)
    {


        $surat = Surat::findOrFail($id);



        Approval::create([

            'surat_id'=>$surat->id,

            'approver_id'=>Auth::id(),

            'urutan'=>2,

            'status'=>'Ditolak',

            'catatan'=>$request->catatan,

            'approved_at'=>now()

        ]);





        $surat->update([

            'status'=>'Ditolak',

            'catatan'=>$request->catatan

        ]);





        return back()->with(

            'success',

            'Surat ditolak KTU.'

        );

    }









    /*
    |--------------------------------------------------------------------------
    | APPROVAL KEPALA STASIUN
    |--------------------------------------------------------------------------
    */

    public function approveKepalaStasiun($id)
    {

        $surat = Surat::findOrFail($id);



        if($surat->status !== 'Menunggu Persetujuan Kepala Stasiun')
        {

            return back()->with(

                'error',

                'Status surat tidak sesuai.'

            );

        }






        Approval::create([

            'surat_id'=>$surat->id,

            'approver_id'=>Auth::id(),

            'urutan'=>3,

            'status'=>'Disetujui',

            'approved_at'=>now()

        ]);





        $surat->update([

            'status'=>'Disetujui',

            'tanggal_selesai'=>now()

        ]);





        return back()->with(

            'success',

            'Surat disetujui Kepala Stasiun.'

        );

    }









    public function rejectKepalaStasiun(Request $request,$id)
    {


        $surat = Surat::findOrFail($id);



        Approval::create([

            'surat_id'=>$surat->id,

            'approver_id'=>Auth::id(),

            'urutan'=>3,

            'status'=>'Ditolak',

            'catatan'=>$request->catatan,

            'approved_at'=>now()

        ]);





        $surat->update([

            'status'=>'Ditolak',

            'catatan'=>$request->catatan

        ]);





        return back()->with(

            'success',

            'Surat ditolak Kepala Stasiun.'

        );

    }


}