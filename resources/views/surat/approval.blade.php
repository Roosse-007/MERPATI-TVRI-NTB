@extends('layouts.app')

@section('title','Approval Surat')

@section('content')


<div class="relative">

<div class="mb-8">

<h1 class="
text-4xl
font-black
text-slate-800
flex
items-center
gap-3
">
<i data-lucide="shield-check" class="w-10 h-10 text-indigo-600"></i>
Approval Surat
</h1>   


<p class="text-slate-500 mt-2">

Pantau perjalanan persetujuan surat secara real-time

</p>

</div>





{{-- STATISTIK --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    {{-- 1. Total Surat --}}
    <a href="{{ route('surat.approval') }}" class="block group">
        <div class="
            relative
            overflow-hidden
            rounded-3xl
            p-8
            h-full
            text-white
            shadow-xl
            bg-gradient-to-br
            from-blue-600
            to-cyan-400
            group-hover:-translate-y-1
            group-hover:shadow-2xl
            transition
            duration-300
            flex
            flex-col
            justify-between
        ">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full"></div>

            <div class="flex items-center justify-between relative z-10">
                <div class="space-y-2">
                    <p class="text-white/80 font-medium text-base">Total Surat</p>
                    <h2 class="text-5xl font-black tracking-tight">{{ $totalSurat }}</h2>
                </div>

                <div class="w-16 h-16 rounded-2xl bg-white/25 backdrop-blur flex items-center justify-center text-3xl shadow-inner shrink-0">
                    <i data-lucide="files" class="w-8 h-8"></i>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-white/10 relative z-10">
                <p class="text-sm text-white/80 font-medium">Jumlah seluruh surat masuk</p>
            </div>
        </div>
    </a>

    {{-- 2. Menunggu --}}
    <a href="{{ route('surat.approval', ['status' => 'Menunggu Approval KPP']) }}" class="block group">
        <div class="
            relative
            overflow-hidden
            rounded-3xl
            p-8
            h-full
            text-white
            shadow-xl
            bg-gradient-to-br
            from-amber-500
            to-orange-400
            group-hover:-translate-y-1
            group-hover:shadow-2xl
            transition
            duration-300
            flex
            flex-col
            justify-between
        ">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full"></div>

            <div class="flex items-center justify-between relative z-10">
                <div class="space-y-2">
                    <p class="text-white/80 font-medium text-base">Menunggu</p>
                    <h2 class="text-5xl font-black tracking-tight">{{ $menunggu }}</h2>
                </div>

                <div class="w-16 h-16 rounded-2xl bg-white/25 backdrop-blur flex items-center justify-center text-3xl shrink-0">
                    <i data-lucide="clock-3" class="w-8 h-8"></i>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-white/10 relative z-10">
                <p class="text-sm text-white/80 font-medium">Surat menunggu persetujuan</p>
            </div>
        </div>
    </a>

    {{-- 3. Disetujui --}}
    <a href="{{ route('surat.approval', ['status' => 'Disetujui']) }}" class="block group">
        <div class="
            relative
            overflow-hidden
            rounded-3xl
            p-8
            h-full
            text-white
            shadow-xl
            bg-gradient-to-br
            from-teal-600
            to-emerald-500
            group-hover:-translate-y-1
            group-hover:shadow-2xl
            transition
            duration-300
            flex
            flex-col
            justify-between
        ">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full"></div>

            <div class="flex items-center justify-between relative z-10">
                <div class="space-y-2">
                    <p class="text-white/80 font-medium text-base">Disetujui</p>
                    <h2 class="text-5xl font-black tracking-tight">{{ $disetujui }}</h2>
                </div>

                <div class="w-16 h-16 rounded-2xl bg-white/25 backdrop-blur flex items-center justify-center shrink-0">
                    <i data-lucide="circle-check-big" class="w-8 h-8"></i>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-white/10 relative z-10">
                <p class="text-sm text-white/80 font-medium">Surat telah disetujui</p>
            </div>
        </div>
    </a>

    {{-- 4. Ditolak --}}
    <a href="{{ route('surat.approval', ['status' => 'Ditolak']) }}" class="block group">
        <div class="
            relative
            overflow-hidden
            rounded-3xl
            p-8
            h-full
            text-white
            shadow-xl
            bg-gradient-to-br
            from-red-500
            to-rose-600
            group-hover:-translate-y-1
            group-hover:shadow-2xl
            transition
            duration-300
            flex
            flex-col
            justify-between
        ">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full"></div>

            <div class="flex items-center justify-between relative z-10">
                <div class="space-y-2">
                    <p class="text-white/80 font-medium text-base">Ditolak</p>
                    <h2 class="text-5xl font-black tracking-tight">{{ $ditolak }}</h2>
                </div>

                <div class="w-16 h-16 rounded-2xl bg-white/25 backdrop-blur flex items-center justify-center text-3xl shrink-0">
                    <i data-lucide="circle-x" class="w-8 h-8"></i>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-white/10 relative z-10">
                <p class="text-sm text-white/80 font-medium">Surat yang ditolak</p>
            </div>
        </div>
    </a>

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
                <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 font-bold inline-flex items-center gap-1.5">
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                    Disetujui
                </span>
            @break

            @case('Ditolak')
                <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 font-bold inline-flex items-center gap-1.5">
                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                    Ditolak
                </span>
            @break

            @default
                <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 font-bold inline-flex items-center gap-1.5">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                    {{ $item->status }}
                </span>

        @endswitch

    </td>

    <td class="px-6 py-5 text-center">

        <div class="flex items-center justify-center gap-2">

            {{-- Tombol Lihat/Detail --}}
            <a href="{{ route('surat.detail', $item->id) }}" class="p-2 rounded-xl bg-sky-100 text-sky-700 hover:bg-sky-200 transition" title="Lihat Detail">
                <i data-lucide="eye" class="w-4 h-4"></i>
            </a>

            {{-- Tahap KPP --}}
            @if(
                auth()->user()->jabatan &&
                auth()->user()->jabatan->nama_jabatan == 'Ketua Tim Perencana dan Pengendali Program' &&
                $item->status == 'Menunggu Approval KPP'
)

                <form method="POST" action="{{ route('approval.kpp.approve', $item->id) }}">
                    @csrf
                    <button class="p-2 rounded-xl bg-green-600 text-white hover:bg-green-700 transition" title="Setujui">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </button>
                </form>

                <form method="POST" action="{{ route('approval.kpp.reject', $item->id) }}">
                    @csrf
                    <button class="p-2 rounded-xl bg-red-600 text-white hover:bg-red-700 transition" title="Tolak">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </form>

            {{-- Tahap KTU --}}
            @elseif(
                auth()->user()->jabatan &&
                auth()->user()->jabatan->nama_jabatan == 'Kepala Sub Bagian Tata Usaha' &&
                $item->status == 'Menunggu Approval KTU'
            )

                <form method="POST" action="{{ route('approval.ktu.approve', $item->id) }}">
                    @csrf
                    <button class="p-2 rounded-xl bg-green-600 text-white hover:bg-green-700 transition" title="Setujui">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </button>
                </form>

                <form method="POST" action="{{ route('approval.ktu.reject', $item->id) }}">
                    @csrf
                    <button class="p-2 rounded-xl bg-red-600 text-white hover:bg-red-700 transition" title="Tolak">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </form>

            {{-- Tahap Kepala Stasiun --}}
            @elseif(
                auth()->user()->jabatan &&
                auth()->user()->jabatan->nama_jabatan == 'Kepala TVRI Stasiun NTB' &&
                $item->status == 'Menunggu Approval Kepala Stasiun'
            )

                <form method="POST" action="{{ route('approval.kepala.approve', $item->id) }}">
                    @csrf
                    <button class="p-2 rounded-xl bg-green-600 text-white hover:bg-green-700 transition" title="Setujui">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </button>
                </form>

                <form method="POST" action="{{ route('approval.kepala.reject', $item->id) }}">
                    @csrf
                    <button class="p-2 rounded-xl bg-red-600 text-white hover:bg-red-700 transition" title="Tolak">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </form>

            @else

                <span class="text-slate-400 font-semibold text-sm">
                    Selesai
                </span>

            @endif

        </div>

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