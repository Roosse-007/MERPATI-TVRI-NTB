<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Menampilkan daftar permission
     */
    public function index()
    {
        $permissions = Permission::orderBy('id', 'asc')->get();

        return view('permission.index', compact('permissions'));
    }


    /**
     * Form tambah permission
     */
    public function create()
    {
        return view('permission.create');
    }


    /**
     * Simpan permission
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);


        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);


        return redirect()
            ->route('permission.index')
            ->with('success', 'Permission berhasil ditambahkan.');
    }


    /**
     * Form edit permission
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('permission.edit', compact('permission'));
    }


    /**
     * Update permission
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);


        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
        ]);


        $permission->update([
            'name' => $request->name,
        ]);


        return redirect()
            ->route('permission.index')
            ->with('success', 'Permission berhasil diperbarui.');
    }


    /**
     * Hapus permission
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        $permission->delete();


        return redirect()
            ->route('permission.index')
            ->with('success', 'Permission berhasil dihapus.');
    }
}