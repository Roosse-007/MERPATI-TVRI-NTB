<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    /**
     * Menampilkan semua unit kerja
     */
    public function index()
    {
        $unitKerja = UnitKerja::orderBy('id', 'asc')->get();

        return view('unit_kerja.index', compact('unitKerja'));
    }


    /**
     * Form tambah unit kerja
     */
    public function create()
    {
        return view('unit_kerja.create');
    }


    /**
     * Simpan unit kerja
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|max:255',
        ]);


        UnitKerja::create([
            'nama_unit' => $request->nama_unit,
        ]);


        return redirect()
            ->route('unit-kerja.index')
            ->with('success', 'Unit Kerja berhasil ditambahkan.');
    }


    /**
     * Detail
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Form edit
     */
    public function edit(string $id)
    {
        $unitKerja = UnitKerja::findOrFail($id);

        return view('unit_kerja.edit', compact('unitKerja'));
    }


    /**
     * Update unit kerja
     */
    public function update(Request $request, string $id)
    {
        $unitKerja = UnitKerja::findOrFail($id);


        $request->validate([
            'nama_unit' => 'required|max:255',
        ]);


        $unitKerja->update([
            'nama_unit' => $request->nama_unit,
        ]);


        return redirect()
            ->route('unit-kerja.index')
            ->with('success', 'Unit Kerja berhasil diperbarui.');
    }


    /**
     * Hapus unit kerja
     */
    public function destroy(string $id)
    {
        $unitKerja = UnitKerja::findOrFail($id);

        $unitKerja->delete();

        return redirect()
            ->route('unit-kerja.index')
            ->with('success', 'Unit Kerja berhasil dihapus.');
    }
}