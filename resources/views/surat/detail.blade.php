@extends('layouts.app')

@section('title', 'Detail Surat')

@section('content')

<div class="space-y-8">

    {{-- Header --}}
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-4xl font-black text-slate-800">
                Detail Surat 📄
            </h1>

            <p class="text-slate-500 mt-2">
                Informasi lengkap surat yang telah diarsipkan
            </p>
        </div>

        <a href="{{ route('surat.arsip') }}"
           class="px-5 py-3 rounded-xl bg-slate-200 hover:bg-slate-300 font-semibold">

            ← Kembali

        </a>

    </div>


    {{-- Informasi Surat --}}
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-2xl font-bold mb-8">
            Informasi Surat
        </h2>

        <div class="grid md:grid-cols-2 gap-8">

            <div>
                <p class="text-sm text-slate-500">Nomor Surat</p>
                <p class="font-bold text-lg">
                    {{ $surat->nomor_surat }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Tanggal Surat</p>
                <p class="font-bold text-lg">
                    {{ optional($surat->tanggal_surat)->format('d M Y') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Perihal</p>
                <p class="font-semibold">
                    {{ $surat->perihal }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Status</p>

                @php
                    $warna = match($surat->status){
                        'Disetujui' => 'bg-green-100 text-green-700',
                        'Ditolak' => 'bg-red-100 text-red-700',
                        default => 'bg-yellow-100 text-yellow-700'
                    };
                @endphp

                <span class="px-4 py-2 rounded-full text-sm font-bold {{ $warna }}">
                    {{ $surat->status }}
                </span>
            </div>

            <div>
                <p class="text-sm text-slate-500">Pengirim</p>

                <p class="font-semibold">

                    {{ $surat->pengirim->name ?? '-' }}

                </p>

                <p class="text-slate-500 text-sm">

                    {{ $surat->pengirim->jabatan->nama_jabatan ?? '' }}

                </p>

            </div>

            <div>
                <p class="text-sm text-slate-500">Tujuan</p>

                <p class="font-semibold">

                    {{ optional($surat->tujuan->first()?->user)->name ?? '-' }}

                </p>

            </div>

        </div>

    </div>



    {{-- Ringkasan --}}
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-2xl font-bold mb-4">
            Ringkasan Surat
        </h2>

        <p class="leading-8 text-slate-700">

            {{ $surat->ringkasan ?: '-' }}

        </p>

    </div>



    {{-- Isi Surat --}}
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-2xl font-bold mb-4">

            Isi Surat

        </h2>

        <div class="leading-8 text-slate-700">

            {!! nl2br(e($surat->isi_surat)) !!}

        </div>

    </div>



    {{-- Approval --}}
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-2xl font-bold mb-6">

            Riwayat Approval

        </h2>

        @forelse($surat->approval as $item)

            <div class="flex justify-between items-center py-4 border-b">

                <div>

                    <p class="font-bold">

                        {{ $item->approver->name ?? '-' }}

                    </p>

                    <p class="text-slate-500">

                        {{ $item->approver->jabatan->nama_jabatan ?? '-' }}

                    </p>

                </div>

                <div class="text-right">

                    <span class="font-semibold">

                        {{ $item->status }}

                    </span>

                    <p class="text-sm text-slate-500">

                        {{ $item->approved_at }}

                    </p>

                </div>

            </div>

        @empty

            <p class="text-slate-500">

                Belum ada approval.

            </p>

        @endforelse

    </div>



    {{-- Disposisi --}}
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-2xl font-bold mb-6">

            Riwayat Disposisi

        </h2>

        @forelse($surat->disposisi as $item)

            <div class="border-b py-5">

                <div class="flex justify-between">

                    <div>

                        <p class="font-bold">

                            {{ $item->dariUser->name ?? '-' }}

                            →

                            {{ $item->keUser->name ?? '-' }}

                        </p>

                        <p class="text-slate-500">

                            {{ $item->instruksi }}

                        </p>

                    </div>

                    <span>

                        {{ $item->status }}

                    </span>

                </div>

            </div>

        @empty

            <p class="text-slate-500">

                Tidak ada disposisi.

            </p>

        @endforelse

    </div>



    {{-- Download --}}
    @if($surat->file_surat)

    <div class="flex justify-end">

        <a href="{{ asset('storage/surat/'.$surat->file_surat) }}"
           target="_blank"
           download
           class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold">

            ⬇ Download Surat

        </a>

    </div>

    @endif

</div>

@endsection