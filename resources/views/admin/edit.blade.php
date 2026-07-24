@extends('layouts.admin')

@section('title','Edit User')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">

        <div class="bg-gradient-to-r from-blue-700 via-blue-600 to-cyan-500
                    rounded-3xl p-8 text-white shadow-xl">

            <div class="flex items-center justify-between">

                <div class="flex items-center gap-5">

                    <div class="w-20 h-20 rounded-2xl
                                bg-white/20
                                flex items-center justify-center
                                backdrop-blur">

                        <i class="bi bi-person-gear text-5xl"></i>

                    </div>

                    <div>

                        <h1 class="text-4xl font-black">

                            Edit Data Pengguna

                        </h1>

                        <p class="text-blue-100 mt-2 text-lg">

                            Perbarui informasi akun pengguna
                            MERPATI TVRI NTB

                        </p>

                    </div>

                </div>

                <div class="hidden lg:block">

                    <span class="bg-white/20
                                 px-5 py-2
                                 rounded-full
                                 text-sm">

                        Administrator Panel

                    </span>

                </div>

            </div>

        </div>

    </div>



    {{-- CONTENT --}}
    <div class="grid grid-cols-12 gap-8">



        {{-- =========================
        FORM
        ========================== --}}

        <div class="col-span-12 lg:col-span-8">

            <div class="bg-white
                        rounded-3xl
                        shadow-xl
                        border border-slate-100
                        overflow-hidden">




                {{-- HEADER CARD --}}

                <div class="border-b
                            px-8
                            py-6
                            bg-slate-50">

                    <div class="flex items-center gap-3">

                        <div class="w-12 h-12 rounded-xl
                                    bg-blue-100
                                    flex items-center justify-center">

                            <i class="bi bi-pencil-square
                                      text-blue-700
                                      text-xl">

                            </i>

                        </div>

                        <div>

                            <h2 class="text-2xl font-bold">

                                Informasi Akun

                            </h2>

                            <p class="text-slate-500">

                                Lengkapi seluruh data pengguna.

                            </p>

                        </div>

                    </div>

                </div>




                {{-- FORM --}}
                <form
                    action="{{ route('users.update',$user->id) }}"
                    method="POST">

                    @csrf
                    @method('PUT')

                    <div class="p-8">

                        <div class="grid grid-cols-2 gap-8">
                                            {{-- Nama --}}

                            <div>

                                <label class="font-semibold text-slate-700">

                                    Divisi

                                </label>

                                <div class="relative mt-2">

                                    <i class="bi bi-person
                                              absolute
                                              left-4
                                              top-1/2
                                              -translate-y-1/2
                                              text-slate-400">

                                    </i>

                                    <input

                                        type="text"

                                        name="name"

                                        value="{{ old('name',$user->name) }}"

                                        class="w-full
                                               pl-12
                                               pr-4
                                               py-3
                                               rounded-xl
                                               border
                                               border-slate-300
                                               focus:ring-4
                                               focus:ring-blue-100
                                               focus:border-blue-500">

                                </div>

                            </div>



                            {{-- Username --}}

                            <div>

                                <label class="font-semibold text-slate-700">

                                    Username

                                </label>

                                <div class="relative mt-2">

                                    <i class="bi bi-at
                                              absolute
                                              left-4
                                              top-1/2
                                              -translate-y-1/2
                                              text-slate-400">

                                    </i>

                                    <input

                                        type="text"

                                        name="username"

                                        value="{{ old('username',$user->username) }}"

                                        class="w-full
                                               pl-12
                                               pr-4
                                               py-3
                                               rounded-xl
                                               border
                                               border-slate-300
                                               focus:ring-4
                                               focus:ring-blue-100
                                               focus:border-blue-500">

                                </div>

                            </div>
                                                        {{-- Email --}}

                            <div>

                                <label class="font-semibold text-slate-700">

                                    Email

                                </label>

                                <div class="relative mt-2">

                                    <i class="bi bi-envelope
                                              absolute
                                              left-4
                                              top-1/2
                                              -translate-y-1/2
                                              text-slate-400">

                                    </i>

                                    <input

                                        type="email"

                                        name="email"

                                        value="{{ old('email',$user->email) }}"

                                        class="w-full
                                               pl-12
                                               pr-4
                                               py-3
                                               rounded-xl
                                               border
                                               border-slate-300
                                               focus:ring-4
                                               focus:ring-blue-100
                                               focus:border-blue-500">

                                </div>

                            </div>



                            {{-- NIP --}}

                            <div>

                                <label class="font-semibold text-slate-700">

                                    NIP

                                </label>

                                <div class="relative mt-2">

                                    <i class="bi bi-credit-card
                                              absolute
                                              left-4
                                              top-1/2
                                              -translate-y-1/2
                                              text-slate-400">

                                    </i>

                                    <input

                                        type="text"

                                        name="nip"

                                        value="{{ old('nip',$user->nip) }}"

                                        class="w-full
                                               pl-12
                                               pr-4
                                               py-3
                                               rounded-xl
                                               border
                                               border-slate-300
                                               focus:ring-4
                                               focus:ring-blue-100
                                               focus:border-blue-500">

                                </div>

                            </div>
                                                       {{-- Unit Kerja --}}
<div>

    <label class="font-semibold text-slate-700">

        Unit Kerja

    </label>

    <div class="relative mt-2">

        <i class="bi bi-building
                  absolute
                  left-4
                  top-1/2
                  -translate-y-1/2
                  text-slate-400"></i>

        <input
    type="text"
    value="TVRI NTB"
    readonly
    class="w-full pl-12 pr-4 py-3 rounded-xl border bg-slate-100">

<input
    type="hidden"
    name="unit_kerja_id"
    value="1">

    </div>

</div>


                    {{-- Role --}}
                <div>

                    <label class="font-semibold text-slate-700">
                        Role
                    </label>

                    <div class="relative mt-2">

                        <i class="bi bi-shield-check
                                absolute left-4 top-1/2
                                -translate-y-1/2
                                text-slate-400"></i>


                        <select
                            name="role"
                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-300">

                            @foreach($roles as $role)

                                <option
                                    value="{{ $role->name }}"
                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>

                                    {{ ucfirst($role->name) }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                           {{-- Status User --}}
<div>

    <label class="font-semibold text-slate-700">
        Status User
    </label>


    <div class="relative mt-2">

        <i class="bi bi-person-check
                  absolute
                  left-4
                  top-1/2
                  -translate-y-1/2
                  text-slate-400">
        </i>


        <select
            name="is_active"
            class="w-full
                   pl-12
                   pr-10
                   py-3
                   rounded-xl
                   border
                   border-slate-300
                   bg-white
                   focus:ring-4
                   focus:ring-blue-100
                   focus:border-blue-500">


            <option value="1"
                {{ $user->is_active == 1 ? 'selected' : '' }}>
                Aktif
            </option>


            <option value="0"
                {{ $user->is_active == 0 ? 'selected' : '' }}>
                Tidak Aktif
            </option>


        </select>

    </div>

</div>

                        </div>



                        <div class="mt-10 border-t pt-6">

                            <div class="flex justify-end gap-4">

                                <a href="{{ route('admin.users') }}"
                                   class="px-6 py-3 rounded-xl border border-slate-300
                                          hover:bg-slate-100">

                                    <i class="bi bi-arrow-left me-2"></i>

                                    Kembali

                                </a>

                                <button
                                    type="submit"
                                    class="px-7 py-3 rounded-xl
                                           bg-gradient-to-r
                                           from-blue-700
                                           to-cyan-500
                                           text-white
                                           shadow-lg
                                           hover:scale-105
                                           transition">

                                    <i class="bi bi-floppy me-2"></i>

                                    Simpan Perubahan

                                </button>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

                {{-- SIDEBAR --}}
        <div class="col-span-12 lg:col-span-4">

            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">

                <div class="flex flex-col items-center">

                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563eb&color=fff&size=200"
                        class="w-28 h-28 rounded-full shadow-lg">

                    <h3 class="text-2xl font-bold mt-5">

                        {{ $user->name }}

                    </h3>

                    <p class="text-slate-500">

                        {{ $user->email }}

                    </p>

                    <span
                        class="mt-4 px-4 py-2 rounded-full
                        {{ $user->is_active
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' }}">

                        {{ $user->is_active ? 'Aktif' : 'Non Aktif' }}

                    </span>

                </div>

                <div class="mt-8 border-t pt-6 space-y-5">

                    <div class="flex justify-between">

                        <span class="text-slate-500">

                            Username

                        </span>

                        <b>{{ $user->username }}</b>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">

                            Role

                        </span>

                        <b>{{ $user->getRoleNames()->first() }}</b>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">

                            Unit

                        </span>

                        <b>{{ $user->unitKerja->nama ?? '-' }}</b>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">

                            Jabatan

                        </span>

                        <b>{{ $user->jabatan->nama ?? '-' }}</b>

                    </div>

                </div>

                <div class="mt-8 rounded-2xl bg-blue-50 p-5">

                    <div class="flex items-start gap-3">

                        <i class="bi bi-info-circle-fill text-blue-600 text-xl"></i>

                        <div>

                            <h5 class="font-bold">

                                Informasi

                            </h5>

                            <p class="text-sm text-slate-600 mt-2">

                                Pastikan data pengguna telah benar
                                sebelum menyimpan perubahan.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection