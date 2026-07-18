@extends('layouts.app')

@section('title','Detail Surat')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">

        <div>

            <h1 class="text-4xl font-black text-slate-800">
                Detail Surat
            </h1>

            <p class="text-slate-500 mt-2">
                Informasi lengkap surat beserta approval dan disposisi.
            </p>

        </div>

        <div class="flex gap-3">

            <a href="{{ route('surat.inbox') }}"
                class="px-5 py-3 rounded-xl bg-slate-200 hover:bg-slate-300 font-semibold">

                ← Kembali

            </a>

            @if($surat->status == 'Disetujui')

                <a href="{{ route('surat.disposisi',$surat->id) }}"
                    class="px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold">

                    Disposisi

                </a>

            @endif

        </div>

    </div>


    {{-- Informasi Surat --}}
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-2xl font-bold mb-6">
            Informasi Surat
        </h2>

        <div class="grid grid-cols-2 gap-6">

            <div>

                <p class="text-slate-500">
                    Nomor Surat
                </p>

                <h3 class="font-bold">
                    {{ $surat->nomor_surat ?? '-' }}
                </h3>

            </div>

            <div>

                <p class="text-slate-500">
                    Perihal
                </p>

                <h3 class="font-bold">
                    {{ $surat->perihal }}
                </h3>

            </div>

            <div>

                <p class="text-slate-500">
                    Pengirim
                </p>

                <h3 class="font-bold">
                    {{ $surat->pengirim->name ?? '-' }}
                </h3>

            </div>

            <div>

                <p class="text-slate-500">
                    Tanggal Surat
                </p>

                <h3 class="font-bold">
                    {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}
                </h3>

            </div>

            <div>

                <p class="text-slate-500">
                    Jenis Surat
                </p>

                <h3 class="font-bold">
                    {{ $surat->jenisSurat->nama ?? '-' }}
                </h3>

            </div>

            <div>

                <p class="text-slate-500">
                    Prioritas
                </p>

                <h3 class="font-bold">
                    {{ $surat->prioritasSurat->nama_prioritas ?? '-' }}
                </h3>

            </div>

        </div>

        <hr class="my-8">

        <h3 class="font-bold mb-3">
            Ringkasan
        </h3>

        <p class="text-slate-600">
            {{ $surat->ringkasan }}
        </p>

        <hr class="my-8">

        <h3 class="font-bold mb-3">
            Isi Surat
        </h3>

        <div class="prose max-w-none">
            {!! nl2br(e($surat->isi_surat)) !!}
        </div>

    </div>


    {{-- Approval --}}
    <div class="bg-white rounded-3xl shadow-lg p-8 mt-8">

        <h2 class="text-2xl font-bold mb-6">
            Riwayat Approval
        </h2>

        @forelse($surat->approval as $approval)

            <div class="border rounded-2xl p-5 mb-4">

                <div class="flex justify-between">

                    <div>

                        <h3 class="font-bold">
                            {{ $approval->approver->name ?? '-' }}
                        </h3>

                        <p class="text-slate-500">
                            {{ $approval->approver->jabatan->nama_jabatan ?? '-' }}
                        </p>

                    </div>

                    <span class="font-bold">

                        {{ $approval->status }}

                    </span>

                </div>

            </div>

        @empty

            <p class="text-slate-500">
                Belum ada approval.
            </p>

        @endforelse

    </div>


    {{-- Disposisi --}}
    <div class="bg-white rounded-3xl shadow-lg p-8 mt-8">

        <h2 class="text-2xl font-bold mb-6">
            Riwayat Disposisi
        </h2>

        @forelse($surat->disposisi as $item)

            <div class="border rounded-2xl p-5 mb-4">

                <div class="flex justify-between">

                    <div>

                        <h3 class="font-bold">

                            {{ $item->dariUser->name ?? '-' }}

                            →

                            {{ $item->keUser->name ?? '-' }}

                        </h3>

                        <p class="text-slate-500 mt-2">

                            {{ $item->instruksi }}

                        </p>

                    </div>

                    <span class="font-bold">

                        {{ $item->status }}

                    </span>

                </div>

            </div>

        @empty

            <p class="text-slate-500">
                Belum ada disposisi.
            </p>

        @endforelse

    </div>

</div>

@endsection