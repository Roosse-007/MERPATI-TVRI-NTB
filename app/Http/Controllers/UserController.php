<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\UnitKerja;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user.
     */
    public function index()
    {
        $users = User::with([
                'unitKerja',
                'jabatan',
                'roles'
            ])
            ->orderBy('id')
            ->get();

        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan form tambah user.
     */
    public function create()
    {
        $unitKerja = UnitKerja::where('is_active', 1)->get();
        $jabatan = Jabatan::where('is_active', 1)->get();
        $roles = Role::all();

        return view('users.create', compact(
            'unitKerja',
            'jabatan',
            'roles'
        ));
    }

    /**
     * Menyimpan user baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|max:255',
            'username'        => 'required|max:255|unique:users,username',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:8',
            'nip'             => 'required|unique:users,nip',
            'unit_kerja_id'   => 'required|exists:unit_kerja,id',
            'jabatan_id'      => 'required|exists:jabatan,id',
            'role'            => 'required',
            'is_active' => 'required|boolean',
        ]);

        $user = User::create([
            'name'            => $request->name,
            'username'        => $request->username,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'nip'             => $request->nip,
            'unit_kerja_id'   => $request->unit_kerja_id,
            'jabatan_id'      => $request->jabatan_id,
            'is_active'       => $request->is_active,
        ]);

        // Assign Role Spatie
        $user->assignRole($request->role);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail user.
     */
    public function show(string $id)
    {
        $user = User::with(['unitKerja', 'jabatan'])->findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Menampilkan form edit user.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        $unitKerja = UnitKerja::where('is_active', 1)->get();
        $jabatan = Jabatan::where('is_active', 1)->get();
        $roles = Role::all();

        return view('users.edit', compact(
            'user',
            'unitKerja',
            'jabatan',
            'roles'
        ));
    }

    /**
     * Mengupdate data user.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'            => 'required|max:255',
            'username'        => 'required|max:255|unique:users,username,' . $user->id,
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'password'        => 'nullable|min:8',
            'nip'             => 'required|unique:users,nip,' . $user->id,
            'unit_kerja_id'   => 'required|exists:unit_kerja,id',
            'jabatan_id'      => 'required|exists:jabatan,id',
            'role'            => 'required',
            'is_active'       => 'required|boolean',
        ]);

        $user->update([
            'name'            => $request->name,
            'username'        => $request->username,
            'email'           => $request->email,
            'nip'             => $request->nip,
            'unit_kerja_id'   => $request->unit_kerja_id,
            'jabatan_id'      => $request->jabatan_id,
            'is_active'       => $request->is_active,
        ]);

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Update role
        $user->syncRoles([$request->role]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus user.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Hapus semua role yang dimiliki user
        $user->syncRoles([]);

        // Hapus user
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}