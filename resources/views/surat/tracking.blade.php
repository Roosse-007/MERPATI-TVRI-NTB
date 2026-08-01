@extends('layouts.app')

@section('title', 'Tracking Surat')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Tracking Surat
            </h1>

            <p class="text-gray-500 mt-1">
                Pantau perjalanan surat dari proses pembuatan hingga selesai.
            </p>
        </div>

        <a href="{{ route('surat.terkirim') }}"
           class="px-5 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg transition">

            <i class="bi bi-arrow-left"></i>
            Kembali

        </a>

    </div>

    {{-- Informasi Surat --}}
    <div class="bg-white rounded-2xl shadow-md p-6 mb-8">

        <h2 class="text-xl font-bold mb-5">
            Informasi Surat
        </h2>

        <div class="grid md:grid-cols-2 gap-5">

            <div>
                <span class="text-gray-500 text-sm">Nomor Surat</span>

                <p class="font-semibold">
                    {{ $surat->nomor_surat ?? '-' }}
                </p>
            </div>

            <div>
                <span class="text-gray-500 text-sm">Status</span>

                <p class="mt-1">

                    @if($surat->status=='Disetujui')

                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                            Disetujui
                        </span>

                    @elseif($surat->status=='Ditolak')

                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">
                            Ditolak
                        </span>

                    @else

                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold">
                            {{ $surat->status }}
                        </span>

                    @endif

                </p>

            </div>

            <div>
                <span class="text-gray-500 text-sm">Perihal</span>

                <p class="font-semibold">
                    {{ $surat->perihal }}
                </p>
            </div>

            <div>
                <span class="text-gray-500 text-sm">Pengirim</span>

                <p class="font-semibold">
                    {{ $surat->pengirim->name ?? '-' }}
                </p>
            </div>

            <div>
                <span class="text-gray-500 text-sm">Tujuan</span>

                <p class="font-semibold">

                    @foreach($surat->tujuan as $tujuan)

                        {{ $tujuan->user->name ?? '-' }}<br>

                    @endforeach

                </p>

            </div>

            <div>
                <span class="text-gray-500 text-sm">Tanggal Surat</span>

                <p class="font-semibold">
                    {{ optional($surat->tanggal_surat)->format('d M Y') ?? '-' }}
                </p>
            </div>

        </div>

    </div>

    {{-- Timeline --}}
    <div class="bg-white rounded-2xl shadow-md p-6">

        <h2 class="text-xl font-bold mb-8">
            Timeline Perjalanan Surat
        </h2>

        <div class="relative border-l-4 border-gray-200 ml-4">

            @foreach($timeline as $item)

                <div class="relative mb-10 ml-8">

                    {{-- Icon --}}
                    <span
                        class="absolute -left-12 flex items-center justify-center
                        w-8 h-8 rounded-full

                        @switch($item['warna'])
                            @case('green')
                                bg-green-600
                                @break

                            @case('blue')
                                bg-blue-600
                                @break

                            @case('red')
                                bg-red-600
                                @break

                            @case('yellow')
                                bg-yellow-500
                                @break

                            @default
                                bg-gray-500
                        @endswitch
                        ">

                        @switch($item['icon'])

                            @case('check')
                                <i class="bi bi-check-lg text-white"></i>
                                @break

                            @case('send')
                                <i class="bi bi-send-fill text-white"></i>
                                @break

                            @case('check-circle')
                                <i class="bi bi-check-circle-fill text-white"></i>
                                @break

                            @case('x-circle')
                                <i class="bi bi-x-circle-fill text-white"></i>
                                @break

                            @case('hourglass')
                                <i class="bi bi-hourglass-split text-white"></i>
                                @break

                            @case('archive')
                                <i class="bi bi-archive-fill text-white"></i>
                                @break

                            @case('flag')
                                <i class="bi bi-flag-fill text-white"></i>
                                @break

                            @default
                                <i class="bi bi-circle-fill text-white"></i>

                        @endswitch

                    </span>

                    {{-- Judul --}}
                    <h3 class="font-bold text-lg text-gray-800">
                        {{ $item['judul'] }}
                    </h3>

                    {{-- Status --}}
                    <div class="mt-2">

                        @if($item['status'] == 'Disetujui')

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                Disetujui
                            </span>

                        @elseif($item['status'] == 'Ditolak')

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                Ditolak
                            </span>

                        @elseif($item['status'] == 'Menunggu')

                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                Menunggu Approval
                            </span>

                        @else

                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">
                                {{ $item['status'] }}
                            </span>

                        @endif

                    </div>

                    {{-- Waktu --}}
                    <p class="text-gray-500 mt-2">

                        @if($item['waktu'])

                            {{ $item['waktu']->format('d M Y • H:i') }}

                        @else

                            Belum diproses

                        @endif

                    </p>

                    {{-- Catatan --}}
                    @if(!empty($item['catatan']))

                        <div class="mt-3 bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-sm text-gray-700">

                            {{ $item['catatan'] }}

                        </div>

                    @endif

                </div>

            @endforeach

        </div>

    </div>

    {{-- Catatan --}}
    <div class="bg-white rounded-2xl shadow-md p-6 mt-8">

        <h2 class="text-xl font-bold mb-4">

            Catatan

        </h2>

        @if($surat->catatan)

            <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-4">

                {{ $surat->catatan }}

            </div>

        @else

            <div class="text-gray-500">

                Tidak ada catatan.

            </div>

        @endif

    </div>

</div>

@endsection