@extends('layouts.app')

@section('title', 'Detail Surat Terkirim')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- ================= HEADER ================= -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">

        <div>

            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">

                <i class="bi bi-file-earmark-text-fill text-blue-600"></i>

                Detail Surat

            </h1>

            <p class="mt-2 text-gray-500">

                Informasi lengkap mengenai surat yang telah dikirim.

            </p>

        </div>

        <div class="flex gap-3">

            <a href="{{ route('surat.terkirim') }}"
               class="inline-flex items-center px-5 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 transition">

                <i class="bi bi-arrow-left me-2"></i>

                Kembali

            </a>

            @if($surat->file_pdf_path)

            <a href="{{ asset('storage/'.$surat->file_pdf_path) }}"
               target="_blank"
               class="inline-flex items-center px-5 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white transition">

                <i class="bi bi-file-earmark-pdf-fill me-2"></i>

                Lihat PDF

            </a>

            @endif

        </div>

    </div>

    <!-- ================= INFORMASI SURAT ================= -->

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <div class="bg-blue-700 px-6 py-4">

            <h2 class="text-white text-lg font-semibold">

                Informasi Surat

            </h2>

        </div>

        <div class="p-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>

                    <label class="text-sm text-gray-500">

                        Nomor Surat

                    </label>

                    <div class="mt-1 font-semibold text-gray-800">

                        {{ $surat->nomor_surat ?? '-' }}

                    </div>

                </div>

                <div>

                    <label class="text-sm text-gray-500">

                        Status

                    </label>

                    <div class="mt-2">

                        @switch($surat->status)

                            @case('Disetujui')

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">

                                <i class="bi bi-check-circle-fill me-1"></i>

                                Disetujui

                            </span>

                            @break

                            @case('Ditolak')

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">

                                <i class="bi bi-x-circle-fill me-1"></i>

                                Ditolak

                            </span>

                            @break

                            @default

                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">

                                <i class="bi bi-hourglass-split me-1"></i>

                                {{ $surat->status }}

                            </span>

                        @endswitch

                    </div>

                </div>

                <div>

                    <label class="text-sm text-gray-500">

                        Jenis Surat

                    </label>

                    <div class="mt-1 font-semibold text-gray-800">

                        {{ $surat->jenisSurat->nama ?? '-' }}

                    </div>

                </div>

                <div>

                    <label class="text-sm text-gray-500">

                        Sifat Surat

                    </label>

                    <div class="mt-1 font-semibold text-gray-800">

                        {{ $surat->sifatSurat->nama ?? '-' }}

                    </div>

                </div>

                <div class="md:col-span-2">

                    <label class="text-sm text-gray-500">

                        Perihal

                    </label>

                    <div class="mt-1 font-semibold text-gray-800">

                        {{ $surat->perihal }}

                    </div>

                </div>

                <div class="md:col-span-2">

                    <label class="text-sm text-gray-500">

                        Isi Surat

                    </label>

                    <div class="mt-3 p-5 border rounded-xl bg-gray-50 leading-relaxed whitespace-pre-line">

                        {{ $surat->isi_surat ?? '-' }}

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- ================= INFORMASI TAMBAHAN ================= -->

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">

        <!-- Pengirim -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

            <div class="bg-gray-100 px-6 py-4 border-b">

                <h3 class="font-semibold text-gray-800 flex items-center gap-2">

                    <i class="bi bi-person-fill text-blue-600"></i>

                    Informasi Pengirim

                </h3>

            </div>

            <div class="p-6 space-y-5">

                <div>

                    <label class="text-sm text-gray-500">

                        Nama Pengirim

                    </label>

                    <div class="mt-1 font-semibold text-gray-800">

                        {{ $surat->pengirim->name ?? '-' }}

                    </div>

                </div>

                <div>

                    <label class="text-sm text-gray-500">

                        Email

                    </label>

                    <div class="mt-1 text-gray-700">

                        {{ $surat->pengirim->email ?? '-' }}

                    </div>

                </div>

                <div>

                    <label class="text-sm text-gray-500">

                        Tanggal Dibuat

                    </label>

                    <div class="mt-1 text-gray-700">

                        {{ $surat->created_at->format('d F Y') }}

                    </div>

                </div>

                <div>

                    <label class="text-sm text-gray-500">

                        Jam

                    </label>

                    <div class="mt-1 text-gray-700">

                        {{ $surat->created_at->format('H:i') }} WIB

                    </div>

                </div>

            </div>

        </div>

        <!-- Tujuan -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

            <div class="bg-gray-100 px-6 py-4 border-b">

                <h3 class="font-semibold text-gray-800 flex items-center gap-2">

                    <i class="bi bi-people-fill text-green-600"></i>

                    Tujuan Surat

                </h3>

            </div>

            <div class="p-6">

                @if($surat->tujuan->count())

                    <div class="space-y-3">

                        @foreach($surat->tujuan as $tujuan)

                            <div class="flex items-center justify-between border rounded-xl p-4 hover:bg-gray-50">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">

                                        <i class="bi bi-person-fill text-blue-600"></i>

                                    </div>

                                    <div>

                                         <div class="font-semibold text-gray-800">
                                            {{ $tujuan->user->name ?? '-' }}
                                        </div>

                                        @if($tujuan->user && $tujuan->user->email)

                                            <div class="text-sm text-gray-500">
                                                {{ $tujuan->user->email }}
                                            </div>

                                        @endif
                                    </div>

                                </div>

                                @if($tujuan->dibaca)

                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs">

                                        Sudah Dibaca

                                    </span>

                                @else

                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs">

                                        Belum Dibaca

                                    </span>

                                @endif

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="text-center py-10 text-gray-400">

                        <i class="bi bi-inbox text-5xl"></i>

                        <p class="mt-3">

                            Tidak ada tujuan surat.

                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

    <!-- ================= PRIORITAS & LAMPIRAN ================= -->

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">

        <!-- Prioritas -->

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

            <div class="bg-gray-100 border-b px-6 py-4">

                <h3 class="font-semibold text-gray-800">

                    Prioritas Surat

                </h3>

            </div>

            <div class="p-6">

                <div class="text-lg font-semibold text-blue-700">

                    {{ $surat->prioritasSurat->nama ?? '-' }}

                </div>

            </div>

        </div>

@if($surat->file_pdf_path)

<div class="bg-white rounded-2xl shadow-lg mt-8 overflow-hidden">

    <div class="bg-blue-700 px-6 py-4">

        <h2 class="text-white font-semibold">

            Preview Surat

        </h2>

    </div>

    <iframe
        src="{{ asset('storage/'.$surat->file_pdf_path) }}"
        class="w-full"
        style="height:900px;">
    </iframe>

</div>

@elseif($surat->file_docx_path)

<div class="bg-white rounded-2xl shadow-lg mt-8 p-6">

    <p class="text-gray-600 mb-4">

        File surat tersedia dalam format DOCX.

    </p>

    <a href="{{ asset('storage/'.$surat->file_docx_path) }}"
       class="inline-flex items-center px-5 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700">

        <i class="bi bi-download me-2"></i>

        Download DOCX

    </a>

</div>

@else

<div class="bg-white rounded-2xl shadow-lg mt-8 p-6">

    <div class="text-gray-500">

        Surat belum memiliki file yang dapat ditampilkan.

    </div>

</div>

@endif
            </div>

        </div>

    </div>

</div>

@endsection