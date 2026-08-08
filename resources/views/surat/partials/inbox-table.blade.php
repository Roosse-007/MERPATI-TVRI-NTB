<div class="mt-8 bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
    {{-- HEADER TABEL --}}
    <div class="flex items-center justify-between px-8 py-6 border-b">

        <div>

            <h2 class="text-2xl font-bold text-slate-800">
                Daftar Surat
            </h2>

            <p class="text-slate-500 mt-1">
                Seluruh surat masuk yang telah diterima.
            </p>

        </div>

        <div class="hidden lg:flex items-center gap-3">

            <div class="px-4 py-2 rounded-xl bg-blue-100 text-blue-700 font-semibold">

                {{ $surat->total() }}

                Surat

            </div>

        </div>

    </div>

  {{-- TABEL --}}
    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-slate-50 border-b">

                <tr>

                    <th class="px-6 py-5 w-20 text-left text-slate-600 font-bold">
                        No
                    </th>

                    <th class="px-6 py-5 text-left text-slate-600 font-bold">
                        Surat
                    </th>

                    <th class="px-6 py-5 text-left text-slate-600 font-bold">
                        Pengirim
                    </th>

                    <th class="px-6 py-5 text-left text-slate-600 font-bold">
                        Perihal
                    </th>

                    <th class="px-6 py-5 text-center text-slate-600 font-bold">
                        Status
                    </th>

                    <th class="px-6 py-5 text-left text-slate-600 font-bold">
                        Tanggal
                    </th>

                    <th class="px-6 py-5 text-center w-52 text-slate-600 font-bold">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

@forelse($surat as $index => $item)

@php

$status = strtolower($item->status);

$badge = 'bg-blue-100 text-blue-700';
$bg = 'bg-blue-600';
$icon = 'bi-envelope-fill';

if(str_contains($status,'disetujui')){
    $badge='bg-green-100 text-green-700';
    $bg='bg-green-600';
    $icon='bi-check-circle-fill';

}elseif(str_contains($status,'ditolak')){
    $badge='bg-red-100 text-red-700';
    $bg='bg-red-600';
    $icon='bi-x-circle-fill';

}elseif(str_contains($status,'menunggu')){
    $badge='bg-yellow-100 text-yellow-700';
    $bg='bg-yellow-500';
    $icon='bi-hourglass-split';

}elseif(str_contains($status,'disposisi')){
    $badge='bg-purple-100 text-purple-700';
    $bg='bg-purple-600';
    $icon='bi-send-fill';

}elseif(str_contains($status,'arsip')){
    $badge='bg-orange-100 text-orange-700';
    $bg='bg-orange-600';
    $icon='bi-archive-fill';
}

$baru = $item->created_at->gt(now()->subDay());

@endphp

<tr class="surat-row border-b border-slate-100 hover:bg-slate-50 transition-all duration-300">

    {{-- NOMOR --}}
    <td class="px-6 py-5">

        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-700 font-bold flex items-center justify-center">

            {{ $surat->firstItem() + $index }}

        </div>

    </td>

    {{-- SURAT --}}
    <td class="px-6 py-5">

        <div class="flex items-center gap-4">

            <div class="w-12 h-12 rounded-2xl {{ $bg }} flex items-center justify-center shadow-md shrink-0">

                <i class="bi {{ $icon }} text-white text-lg"></i>

            </div>

            <div>

                <div class="flex items-center gap-2">

                    <h4 class="font-bold text-slate-800">

                        {{ $item->nomor_surat }}

                    </h4>

                    @if($baru)

                        <span class="px-2 py-1 rounded-full bg-red-500 text-white text-[10px] font-bold animate-pulse">

                            BARU

                        </span>

                    @endif

                </div>

                <p class="text-xs text-slate-500 mt-1">

                    {{ $item->kode_surat ?? 'Surat Elektronik' }}

                </p>

            </div>

        </div>

    </td>

    {{-- PENGIRIM --}}
    <td class="px-6 py-5">

        <div class="flex items-center gap-3">

            <div class="w-11 h-11 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-bold flex items-center justify-center">

                {{ strtoupper(substr($item->pengirim->name ?? 'U',0,1)) }}

            </div>

            <div>

                <div class="font-semibold text-slate-800">

                    {{ $item->pengirim->name ?? '-' }}

                </div>

                <div class="text-xs text-slate-500 mt-1">

                    {{ optional($item->pengirim->jabatan)->nama_jabatan ?? '-' }}

                </div>

            </div>

        </div>

    </td>

        {{-- PERIHAL --}}
    <td class="px-6 py-5">

        <div class="font-semibold text-slate-700">

            {{ \Illuminate\Support\Str::limit($item->perihal,60) }}

        </div>

        @if(!empty($item->ringkasan))

            <div class="text-xs text-slate-400 mt-1">

                {{ \Illuminate\Support\Str::limit($item->ringkasan,70) }}

            </div>

        @endif

    </td>

    {{-- STATUS --}}
    <td class="px-6 py-5 text-center">

        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold {{ $badge }}">

            <span class="w-2 h-2 rounded-full bg-current"></span>

            {{ $item->status }}

        </span>

    </td>

    {{-- TANGGAL --}}
    <td class="px-6 py-5">

        <div class="font-semibold text-slate-700">

            {{ $item->created_at->format('d M Y') }}

        </div>

        <div class="text-xs text-slate-400 mt-1">

            {{ $item->created_at->format('H:i') }}

        </div>

        <div class="text-xs text-blue-600 mt-1">

            {{ $item->created_at->diffForHumans() }}

        </div>

    </td>

    {{-- AKSI --}}
    <td class="px-6 py-5">

        <div class="flex justify-center items-center gap-2">

            {{-- LIHAT --}}
            <a href="/surat/{{ $item->id }}/detail"
               class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white hover:scale-110 active:scale-95 transition-all duration-200 flex items-center justify-center"
               title="Lihat Surat">

                <i class="bi bi-eye-fill"></i>

            </a>

            {{-- DOWNLOAD --}}
            @if($item->file_surat)

            <a href="{{ route('surat.download',$item) }}"
            class="download-btn w-10 h-10 rounded-xl bg-slate-100 text-slate-500 hover:bg-green-600 hover:text-white hover:scale-110 active:scale-95 transition-all duration-200 flex items-center justify-center"
            title="Download Surat">

                <i class="bi bi-download"></i>

            </a>

            @else

            <button
                disabled
                class="w-10 h-10 rounded-xl bg-slate-100 text-slate-300 cursor-not-allowed flex items-center justify-center"
                title="File belum tersedia">

                <i class="bi bi-download"></i>
    
            </button>

            @endif

                {{-- ARSIP --}}
                <form
                    action="{{ route('surat.archive',$item->id) }}"
                    method="POST"
                    onsubmit="return confirm('Arsipkan surat ini?')">

                    @csrf

                    <button
                        type="submit"
                        class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 hover:bg-orange-600 hover:text-white hover:scale-110 transition flex items-center justify-center"
                        title="Arsipkan">

                        <i class="bi bi-archive-fill"></i>

                    </button>

                </form>
        </div>

    </td>

</tr>

@empty

<tr>

    <td colspan="7">

        <div class="py-24 flex flex-col items-center">

            <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center">

                <i class="bi bi-inbox text-5xl text-slate-400"></i>

            </div>

            <h3 class="mt-6 text-2xl font-bold text-slate-700">

                Belum Ada Surat

            </h3>

            <p class="mt-3 text-slate-400">

                Surat masuk akan muncul di sini.

            </p>

        </div>

    </td>

</tr>

@endforelse

            </tbody>

        </table>

    </div>

@if($surat->hasPages())

<div class="flex justify-between items-center px-8 py-6 border-t bg-slate-50">

    {{-- INFORMASI --}}
    <div class="text-sm text-slate-500">

        Menampilkan

        <span class="font-bold text-slate-700">

            {{ $surat->firstItem() }}

        </span>

        -

        <span class="font-bold text-slate-700">

            {{ $surat->lastItem() }}

        </span>

        dari

        <span class="font-bold text-blue-700">

            {{ $surat->total() }}

        </span>

        surat

    </div>

    {{-- PAGINATION --}}
    <div class="flex items-center gap-2">

        {{-- Previous --}}
        @if($surat->onFirstPage())

            <span class="w-10 h-10 rounded-xl bg-slate-200 text-slate-400 flex items-center justify-center">

                <i class="bi bi-chevron-left"></i>

            </span>

        @else

            <a href="{{ $surat->previousPageUrl() }}"
               class="pagination-link w-10 h-10 rounded-xl border border-slate-300 bg-white hover:bg-blue-600 hover:text-white transition flex items-center justify-center">

                <i class="bi bi-chevron-left"></i>

            </a>

        @endif

        @php
            $start = max($surat->currentPage()-2,1);
            $end   = min($start+4,$surat->lastPage());

            if($end-$start<4){
                $start=max($end-4,1);
            }
        @endphp

        @for($page=$start;$page<=$end;$page++)

            <a href="{{ $surat->url($page) }}"
               class="pagination-link w-10 h-10 rounded-xl flex items-center justify-center font-semibold transition
               {{ $page==$surat->currentPage()
                    ? 'bg-blue-600 text-white shadow-lg'
                    : 'bg-white border border-slate-300 hover:bg-blue-50' }}">

                {{ $page }}

            </a>

        @endfor

        {{-- Next --}}
        @if($surat->hasMorePages())

            <a href="{{ $surat->nextPageUrl() }}"
               class="pagination-link w-10 h-10 rounded-xl border border-slate-300 bg-white hover:bg-blue-600 hover:text-white transition flex items-center justify-center">

                <i class="bi bi-chevron-right"></i>

            </a>

        @else

            <span class="w-10 h-10 rounded-xl bg-slate-200 text-slate-400 flex items-center justify-center">

                <i class="bi bi-chevron-right"></i>

            </span>

        @endif

    </div>

</div>

@endif

</div>