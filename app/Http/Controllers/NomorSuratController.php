<?php

namespace App\Http\Controllers;

use App\Models\NomorSurat;
use App\Models\JenisSurat;
use Illuminate\Http\Request;

class NomorSuratController extends Controller
{


    /**
     * Halaman daftar nomor surat
     */
    public function index(Request $request)
    {


        $query = NomorSurat::with('jenisSurat');



        // SEARCH

        if($request->filled('search')){

            $query->where(
                'kode_nomor',
                'like',
                '%'.$request->search.'%'
            );

        }



        // FILTER TAHUN

        if($request->filled('tahun')){

            $query->where(
                'tahun',
                $request->tahun
            );

        }



        // FILTER STATUS

        if($request->filled('status')){

            $query->where(
                'status',
                $request->status
            );

        }



        // DATA TABLE

        $nomorSurat = $query
            ->orderBy('id','desc')
            ->paginate(10);



        // =====================
        // STATISTIK REAL DATABASE
        // =====================


        $totalFormat =
            NomorSurat::count();



        $tahunAktif =
            NomorSurat::max('tahun');



        $nomorTerakhir =
            NomorSurat::max('nomor_terakhir');



        $digunakanHariIni =
            NomorSurat::whereDate(
                'updated_at',
                today()
            )->count();



        $tahunList =
            NomorSurat::select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');



        $jenisSurat =
            JenisSurat::all();





        return view(
            'admin.nomor-surat',
            compact(
                'nomorSurat',
                'totalFormat',
                'tahunAktif',
                'nomorTerakhir',
                'digunakanHariIni',
                'tahunList',
                'jenisSurat'
            )
        );


    }







    /**
     * Simpan nomor surat baru
     */
    public function store(Request $request)
    {


        $request->validate([


            'jenis_surat_id'
            =>'required|exists:jenis_surat,id',


            'kode_nomor'
            =>'required|max:50',


            'tahun'
            =>'required',


        ]);





        NomorSurat::create([


            'jenis_surat_id'
            =>$request->jenis_surat_id,


            'kode_nomor'
            =>$request->kode_nomor,


            'nomor_terakhir'
            =>0,


            'tahun'
            =>$request->tahun,


            'status'
            =>'Aktif'


        ]);





        return redirect()

        ->route('admin.nomor')

        ->with(
            'success',
            'Nomor surat berhasil ditambahkan'
        );


    }









    /**
     * Ambil data edit via AJAX
     */
    public function edit($id)
    {


        $nomorSurat =
            NomorSurat::findOrFail($id);



        return response()->json([

            'id'=>$nomorSurat->id,

            'kode_nomor'=>$nomorSurat->kode_nomor,

            'nomor_terakhir'=>
            str_pad(
                $nomorSurat->nomor_terakhir,
                5,
                '0',
                STR_PAD_LEFT
            ),


            'tahun'=>$nomorSurat->tahun,


            'status'=>$nomorSurat->status


        ]);


    }









    /**
     * Update nomor surat
     */
    public function update(
        Request $request,
        $id
    )
    {



        $request->validate([


            'kode_nomor'
            =>'required|max:50',


            'nomor_terakhir'
            =>'required',


            'tahun'
            =>'required',


            'status'
            =>'required'


        ]);






        $nomorSurat =
            NomorSurat::findOrFail($id);







        $nomorSurat->update([



            'kode_nomor'
            =>
            $request->kode_nomor,



            'nomor_terakhir'
            =>
            intval(
                $request->nomor_terakhir
            ),



            'tahun'
            =>
            $request->tahun,



            'status'
            =>
            $request->status



        ]);








        return redirect()

        ->route('admin.nomor')

        ->with(
            'success',
            'Nomor surat berhasil diperbarui'
        );



    }









    /**
     * Hapus nomor surat
     */
    public function destroy($id)
    {


        $nomorSurat =
            NomorSurat::findOrFail($id);



        $nomorSurat->delete();





        return redirect()

        ->route('admin.nomor')

        ->with(
            'success',
            'Nomor surat berhasil dihapus'
        );


    }



}