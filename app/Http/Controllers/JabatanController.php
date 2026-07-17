<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Menampilkan daftar jabatan
     */
    public function index()
    {
        $jabatan = Jabatan::orderBy('id', 'asc')->get();

        return view('jabatan.index', compact('jabatan'));
    }


    /**
     * Form tambah jabatan
     */
    public function create()
    {
        return view('jabatan.create');
    }


    /**
     * Simpan jabatan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|max:255',
            'deskripsi' => 'nullable',
            'is_active' => 'required',
        ]);


        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->is_active,
        ]);


        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }


    /**
     * Detail jabatan
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Form edit jabatan
     */
    public function edit(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        return view('jabatan.edit', compact('jabatan'));
    }


    /**
     * Update jabatan
     */
    public function update(Request $request, string $id)
    {
        $jabatan = Jabatan::findOrFail($id);


        $request->validate([
            'nama_jabatan' => 'required|max:255',
            'deskripsi' => 'nullable',
            'is_active' => 'required',
        ]);


        $jabatan->update([
            'nama_jabatan' => $request->nama_jabatan,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->is_active,
        ]);


        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }


    /**
     * Hapus jabatan
     */
    public function destroy(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $jabatan->delete();


        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Jabatan berhasil dihapus.');
    }
}