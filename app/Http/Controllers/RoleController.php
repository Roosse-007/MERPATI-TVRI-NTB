<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id', 'asc')->get();

        return view('role.index', compact('roles'));
    }


    public function create()
    {
        return view('role.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);


        Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);


        return redirect()
            ->route('role.index')
            ->with('success', 'Role berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return view('role.edit', compact('role'));
    }


    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);


        $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
        ]);


        $role->update([
            'name' => $request->name,
        ]);


        return redirect()
            ->route('role.index')
            ->with('success', 'Role berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $role->delete();


        return redirect()
            ->route('role.index')
            ->with('success', 'Role berhasil dihapus.');
    }
}