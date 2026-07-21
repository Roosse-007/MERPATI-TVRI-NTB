@extends('layouts.app')

@section('title','Approval Surat')

@section('content')


<div class="relative">


{{-- MERPATI --}}
<x-flying-dove />



<div class="mb-8">

<h1 class="
text-4xl
font-black
text-slate-800
">

Approval Surat ✅

</h1>


<p class="text-slate-500 mt-2">

Pantau perjalanan persetujuan surat secara real-time

</p>

</div>





{{-- STATISTIK --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    {{-- Total Surat --}}
    <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-900 rounded-3xl p-6 shadow-2xl hover:-translate-y-1 duration-300 text-white">

        <div class="flex items-center gap-2 text-slate-300 text-sm">
            <i data-lucide="files" class="w-5 h-5"></i>
            <span>Total Surat</span>
        </div>

        <h2 class="text-5xl font-black mt-3">
            {{ $totalSurat }}
        </h2>

    </div>

    {{-- Menunggu --}}
    <div class="bg-gradient-to-br from-amber-900 via-yellow-900 to-orange-900 rounded-3xl p-6 shadow-2xl hover:-translate-y-1 duration-300 text-white">

        <div class="flex items-center gap-2 text-amber-200 text-sm">
            <i data-lucide="clock-3" class="w-5 h-5"></i>
            <span>Menunggu</span>
        </div>

        <h2 class="text-5xl font-black mt-3">
            {{ $menunggu }}
        </h2>

    </div>

    {{-- Disetujui --}}
    <div class="bg-gradient-to-br from-emerald-900 via-green-900 to-teal-900 rounded-3xl p-6 shadow-2xl hover:-translate-y-1 duration-300 text-white">

        <div class="flex items-center gap-2 text-emerald-200 text-sm">
            <i data-lucide="circle-check-big" class="w-5 h-5"></i>
            <span>Disetujui</span>
        </div>

        <h2 class="text-5xl font-black mt-3">
            {{ $disetujui }}
        </h2>

    </div>

    {{-- Ditolak --}}
    <div class="bg-gradient-to-br from-rose-900 via-red-900 to-red-800 rounded-3xl p-6 shadow-2xl hover:-translate-y-1 duration-300 text-white">

        <div class="flex items-center gap-2 text-red-200 text-sm">
            <i data-lucide="circle-x" class="w-5 h-5"></i>
            <span>Ditolak</span>
        </div>

        <h2 class="text-5xl font-black mt-3">
            {{ $ditolak }}
        </h2>

    </div>

</div>


<div class="bg-white rounded-[32px] shadow-xl overflow-hidden">

    {{-- HEADER TABLE --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 p-8 border-b">

        <div>

            <h2 class="text-2xl font-black text-slate-800">
                Daftar Approval Surat
            </h2>

            <p class="text-slate-500 mt-1">
                Seluruh proses approval surat TVRI NTB
            </p>

        </div>

    </div>





    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-slate-50">

                <tr>

                    <th class="px-6 py-5 text-left font-bold text-slate-600">
                        No
                    </th>

                    <th class="px-6 py-5 text-left font-bold text-slate-600">
                        Nomor Surat
                    </th>

                    <th class="px-6 py-5 text-left font-bold text-slate-600">
                        Perihal
                    </th>

                    <th class="px-6 py-5 text-left font-bold text-slate-600">
                        Pengirim
                    </th>

                    <th class="px-6 py-5 text-left font-bold text-slate-600">
                        Tujuan
                    </th>

                    <th class="px-6 py-5 text-left font-bold text-slate-600">
                        Tanggal
                    </th>

                    <th class="px-6 py-5 text-center font-bold text-slate-600">
                        Status
                    </th>

                    <th class="px-6 py-5 text-center font-bold text-slate-600">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

@foreach($surat as $item)

<tr class="border-b hover:bg-sky-50 duration-300">

    <td class="px-6 py-5 font-semibold">
        {{ $loop->iteration }}
    </td>

    <td class="px-6 py-5 font-bold text-blue-600">
        {{ $item->nomor_surat }}
    </td>

    <td class="px-6 py-5">
        {{ $item->perihal }}
    </td>

    <td class="px-6 py-5">
        {{ $item->pengirim->name ?? '-' }}
    </td>

    <td class="px-6 py-5">
        {{ optional($item->tujuan->first()?->user)->name ?? '-' }}
    </td>

    <td class="px-6 py-5">
        {{ $item->tanggal_surat?->format('d M Y') }}
    </td>

    <td class="px-6 py-5 text-center">

        @switch($item->status)

            @case('Disetujui')
                <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 font-bold">
                    Disetujui
                </span>
            @break

            @case('Ditolak')
                <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 font-bold">
                    Ditolak
                </span>
            @break

            @default
                <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 font-bold">
                    {{ $item->status }}
                </span>

        @endswitch

    </td>

    <td class="px-6 py-5 text-center">

    {{-- Tahap KPP --}}
    @if($item->status == 'Menunggu Approval KPP')

        <div class="flex justify-center gap-2">

            <form method="POST" action="{{ route('approval.kpp.approve', $item->id) }}">
                @csrf
                <button
                    class="px-4 py-2 rounded-xl bg-green-600 text-white font-bold hover:bg-green-700">
                    ✓ Setujui
                </button>
            </form>

            <form method="POST" action="{{ route('approval.kpp.reject', $item->id) }}">
                @csrf
                <button
                    class="px-4 py-2 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700">
                    ✕ Tolak
                </button>
            </form>

        </div>

    {{-- Tahap KTU --}}
    @elseif($item->status == 'Menunggu Approval KTU')

        <div class="flex justify-center gap-2">

            <form method="POST" action="{{ route('approval.ktu.approve', $item->id) }}">
                @csrf
                <button
                    class="px-4 py-2 rounded-xl bg-green-600 text-white font-bold hover:bg-green-700">
                    ✓ Setujui
                </button>
            </form>

            <form method="POST" action="{{ route('approval.ktu.reject', $item->id) }}">
                @csrf
                <button
                    class="px-4 py-2 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700">
                    ✕ Tolak
                </button>
            </form>

        </div>

    {{-- Tahap Kepala Stasiun --}}
    @elseif($item->status == 'Menunggu Approval Kepala Stasiun')

        <div class="flex justify-center gap-2">

            <form method="POST" action="{{ route('approval.kepala.approve', $item->id) }}">
                @csrf
                <button
                    class="px-4 py-2 rounded-xl bg-green-600 text-white font-bold hover:bg-green-700">
                    ✓ Setujui
                </button>
            </form>

            <form method="POST" action="{{ route('approval.kepala.reject', $item->id) }}">
                @csrf
                <button
                    class="px-4 py-2 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700">
                    ✕ Tolak
                </button>
            </form>

        </div>

    @else

        <span class="text-slate-400 font-semibold">
            Selesai
        </span>

    @endif

</td>

</tr>

@endforeach

</tbody>

        </table>

    </div>

</div>



</div>



</div>



</div>


@endsection