@extends('layouts.app')

@section('title','Surat Terkirim')

@section('content')

<!-- ========================= HEADER ========================= -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">

    <div>

        <h1 class="flex items-center gap-3 text-3xl font-bold text-gray-800">

            <i class="bi bi-send-check-fill text-blue-600"></i>

            Surat Terkirim

        </h1>

        <p class="mt-2 text-gray-500">

            Menampilkan seluruh surat yang telah berhasil dikirim oleh pengguna.
            Gunakan fitur pencarian dan filter untuk menemukan surat berdasarkan
            nomor surat, perihal, atau status pengiriman.

        </p>

        @if(session('success'))

            <div class="mt-5 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">

                <i class="bi bi-check-circle-fill text-xl"></i>

                <span>{{ session('success') }}</span>

            </div>

        @endif

    </div>

    <div class="flex gap-3">

        <a href="{{ route('surat.create') }}"
           class="inline-flex items-center rounded-xl bg-blue-700 px-5 py-3 font-semibold text-white shadow hover:bg-blue-800 transition">

            <i class="bi bi-plus-circle me-2"></i>

            Surat Baru

        </a>

    </div>

</div>
<!-- ======================= END HEADER ======================= -->

<!-- ======================= STATISTIK ======================= -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <!-- Total Surat -->
    <div class="bg-gradient-to-r from-blue-700 to-blue-500 rounded-2xl shadow-lg text-white p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-blue-100 text-sm">
                    Total Surat Terkirim
                </p>

                <h2 class="text-4xl font-bold mt-3">
                    {{ $surat->total() }}
                </h2>

            </div>

            <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center">

                <i class="bi bi-send-fill text-3xl"></i>

            </div>

        </div>

    </div>

    <!-- Menunggu Approval -->
    <div class="bg-gradient-to-r from-amber-500 to-yellow-400 rounded-2xl shadow-lg text-white p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-yellow-100 text-sm">
                    Menunggu Approval
                </p>

                <h2 class="text-4xl font-bold mt-3">

                    {{ $surat->whereNotIn('status',['Disetujui','Ditolak'])->count() }}

                </h2>

            </div>

            <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center">

                <i class="bi bi-hourglass-split text-3xl"></i>

            </div>

        </div>

    </div>

    <!-- Disetujui -->
    <div class="bg-gradient-to-r from-green-600 to-green-400 rounded-2xl shadow-lg text-white p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-green-100 text-sm">
                    Disetujui
                </p>

                <h2 class="text-4xl font-bold mt-3">

                    {{ $surat->where('status','Disetujui')->count() }}

                </h2>

            </div>

            <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center">

                <i class="bi bi-check-circle-fill text-3xl"></i>

            </div>

        </div>

    </div>

    <!-- Ditolak -->
    <div class="bg-gradient-to-r from-red-600 to-red-400 rounded-2xl shadow-lg text-white p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-red-100 text-sm">
                    Ditolak
                </p>

                <h2 class="text-4xl font-bold mt-3">

                    {{ $surat->where('status','Ditolak')->count() }}

                </h2>

            </div>

            <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center">

                <i class="bi bi-x-circle-fill text-3xl"></i>

            </div>

        </div>

    </div>

</div>
<!-- ===================== END STATISTIK ===================== -->


<!-- ======================= FILTER & PENCARIAN ======================= -->

<div class="bg-white rounded-2xl shadow-lg p-6 mb-8">

    <div class="flex items-center gap-2 mb-5">

        <i class="bi bi-funnel-fill text-blue-600 text-lg"></i>

        <h2 class="text-lg font-semibold text-gray-800">

            Filter Pencarian Surat

        </h2>

    </div>

    <form action="{{ route('surat.terkirim') }}" method="GET">

        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">

            <!-- Search -->
            <div class="md:col-span-5">

                <label class="block text-sm font-medium text-gray-700 mb-2">

                    Kata Kunci

                </label>

                <div class="relative">

                    <span class="absolute left-4 top-3.5 text-gray-400">

                        <i class="bi bi-search"></i>

                    </span>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Nomor surat atau perihal..."
                        class="w-full rounded-xl border border-gray-300 pl-11 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                </div>

            </div>

            <!-- Status -->
            <div class="md:col-span-4">

                <label class="block text-sm font-medium text-gray-700 mb-2">

                    Status Surat

                </label>

                <select
                    name="status"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500">

                    <option value="">Semua Status</option>

                    <option value="Menunggu Approval KPP"
                        {{ request('status')=='Menunggu Approval KPP' ? 'selected' : '' }}>
                        Menunggu Approval KPP
                    </option>

                    <option value="Menunggu Approval KTU"
                        {{ request('status')=='Menunggu Approval KTU' ? 'selected' : '' }}>
                        Menunggu Approval KTU
                    </option>

                    <option value="Menunggu Approval Kepala Stasiun"
                        {{ request('status')=='Menunggu Approval Kepala Stasiun' ? 'selected' : '' }}>
                        Menunggu Approval Kepala Stasiun
                    </option>

                    <option value="Disetujui"
                        {{ request('status')=='Disetujui' ? 'selected' : '' }}>
                        Disetujui
                    </option>

                    <option value="Ditolak"
                        {{ request('status')=='Ditolak' ? 'selected' : '' }}>
                        Ditolak
                    </option>

                </select>

            </div>

            <!-- Tombol -->
            <div class="md:col-span-3 flex items-end gap-3">

                <button
                    type="submit"
                    class="flex-1 bg-blue-700 hover:bg-blue-800 text-white rounded-xl py-3 transition">

                    <i class="bi bi-search me-2"></i>

                    Cari

                </button>

                <a
                    href="{{ route('surat.terkirim') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl px-4 py-3 transition">

                    <i class="bi bi-arrow-clockwise"></i>

                </a>

            </div>

        </div>

    </form>

</div>

<!-- ===================== END FILTER ====================== -->

<!-- TABEL -->

<div id="tableContainer"
     class="bg-white rounded-2xl shadow overflow-hidden transition-all duration-300">

<div class="overflow-x-auto">

<table class="w-full">

<thead class="bg-blue-700 text-white">

<tr>

<th class="p-4 text-left">No</th>

<th>Nomor Surat</th>

<th>Perihal</th>

<th>Tujuan</th>

<th>Status</th>

<th>Tanggal</th>

<th>Aksi</th>

</tr>

</thead>

<tbody class="divide-y divide-gray-100">

@forelse($surat as $item)

<tr class="hover:bg-gray-50 transition">

    <!-- No -->
    <td class="px-6 py-5 text-center text-sm text-gray-600">
        {{ $loop->iteration + ($surat->firstItem() - 1) }}
    </td>

    <!-- Nomor Surat -->
    <td class="px-6 py-5">

        <div class="font-semibold text-gray-800">

            {{ $item->nomor_surat ?? '-' }}

        </div>

        @if($item->jenisSurat)

            <div class="text-xs text-gray-500 mt-1">
                {{ $item->jenisSurat->nama_jenis ?? '-' }}
            </div>

        @endif

    </td>

    <!-- Perihal -->
    <td class="px-6 py-5">

        <div class="font-medium text-gray-800">

            {{ $item->perihal }}

        </div>

        @if($item->sifatSurat)

            <div class="text-xs text-gray-500 mt-1">

                Sifat :
                {{ $item->sifatSurat->nama_sifat ?? '-' }}

            </div>

        @else

            <div class="text-xs text-gray-400 mt-1">
                Sifat : -
            </div>

        @endif

    </td>

    <!-- Tujuan -->
    <td class="px-6 py-5">

        @if($item->tujuan->isNotEmpty())

            <div class="flex flex-wrap gap-2">

                @foreach($item->tujuan as $tujuan)

                    <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">

                        <i class="bi bi-person-fill me-1"></i>

                        {{ $tujuan->user->name ?? '-' }}

                    </span>

                @endforeach

            </div>

        @else

            <span class="italic text-gray-400">

                Tidak ada tujuan

            </span>

        @endif

    </td>

    <!-- Status -->
    <td class="px-6 py-5">

        @switch($item->status)

            @case('Disetujui')

                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">

                    <i class="bi bi-check-circle-fill me-1"></i>

                    Disetujui

                </span>

            @break

            @case('Ditolak')

                <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">

                    <i class="bi bi-x-circle-fill me-1"></i>

                    Ditolak

                </span>

            @break

            @default

                <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">

                    <i class="bi bi-hourglass-split me-1"></i>

                    {{ $item->status }}

                </span>

        @endswitch

    </td>

    <!-- Tanggal -->
    <td class="px-6 py-5 whitespace-nowrap">

        <div class="text-sm text-gray-700">

            {{ $item->created_at->format('d M Y') }}

        </div>

        <div class="text-xs text-gray-500">

            {{ $item->created_at->format('H:i') }} WITA

        </div>

    </td>

    <!-- Aksi -->
    <td class="px-6 py-5">

        <div class="flex items-center gap-2">

            @if($item->file_surat)

            <a href="{{ route('surat.terkirim.show',$item->id) }}"
            target="_blank"
            class="text-blue-600 hover:text-blue-800"
            title="Lihat Surat">

                <i class="bi bi-eye-fill"></i>

            </a>

            @else

            <span class="text-gray-400 cursor-not-allowed"
                title="Tidak ada lampiran">

                <i class="bi bi-eye-slash-fill"></i>

            </span>

            @endif

            <!-- Tracking -->
            <a href="{{ route('surat.terkirim.tracking',$item->id) }}"
               class="w-10 h-10 rounded-lg bg-yellow-100 text-yellow-700 hover:bg-yellow-500 hover:text-white flex items-center justify-center transition"
               title="Tracking">

                <i class="bi bi-geo-alt-fill"></i>

            </a>

            <!-- PDF -->
            @if($item->file_pdf_path)

                <a href="{{ asset('storage/'.$item->file_pdf_path) }}"
                   target="_blank"
                   class="w-10 h-10 rounded-lg bg-red-100 text-red-700 hover:bg-red-600 hover:text-white flex items-center justify-center transition"
                   title="PDF">

                    <i class="bi bi-file-earmark-pdf-fill"></i>

                </a>

            @endif

        </div>

    </td>

</tr>

@empty

<tr>

    <td colspan="7" class="py-16 text-center">

        <i class="bi bi-inbox text-5xl text-gray-300"></i>

        <div class="mt-4 text-lg font-semibold text-gray-600">

            Belum ada surat terkirim

        </div>

        <div class="text-gray-400 mt-2">

            Surat yang berhasil dikirim akan muncul di halaman ini.

        </div>

    </td>

</tr>

@endforelse

</tbody>

</table>

</div>

<!-- ======================= FOOTER TABEL ======================= -->

<div class="bg-white border-t border-gray-200 px-6 py-4">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <!-- Informasi Data -->
        <div class="text-sm text-gray-600">

            @if($surat->count())

                Menampilkan
                <span class="font-semibold text-gray-800">
                    {{ $surat->firstItem() }}
                </span>
                -
                <span class="font-semibold text-gray-800">
                    {{ $surat->lastItem() }}
                </span>
                dari
                <span class="font-semibold text-gray-800">
                    {{ $surat->total() }}
                </span>
                surat terkirim.

            @else

                Tidak ada data yang ditampilkan.

            @endif

        </div>

        <!-- Pagination -->
        @if($surat->hasPages())

            <div>
                {{ $surat->withQueryString()->links() }}
            </div>

        @endif

    </div>

</div>

</div>
<div id="paginationLoading"
     class="hidden absolute inset-0 bg-white/60 backdrop-blur-[1px] z-20 items-center justify-center">

    <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-xl shadow-lg border border-slate-200">

        <div class="w-5 h-5 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>

        <span class="text-sm font-medium text-slate-600">
            Memuat data...
        </span>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const tableContainer = document.getElementById('tableContainer');

    if (!tableContainer) return;


    function initPagination() {

        tableContainer
            .querySelectorAll('a[href*="page="]')
            .forEach(function (link) {

                if (link.dataset.paginationReady) {
                    return;
                }

                link.dataset.paginationReady = 'true';

                link.addEventListener('click', function (e) {

                    e.preventDefault();

                    loadPage(this.href);

                });

            });

    }


    function loadPage(url) {

        /*
        |--------------------------------------------------------------------------
        | ANIMASI KELUAR
        |--------------------------------------------------------------------------
        */

        tableContainer.style.transition =
            'opacity 0.25s ease, transform 0.25s ease';

        tableContainer.style.opacity = '0.35';

        tableContainer.style.transform =
            'translateX(30px)';


        /*
        |--------------------------------------------------------------------------
        | AMBIL HALAMAN BARU
        |--------------------------------------------------------------------------
        */

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })

        .then(function (response) {

            if (!response.ok) {
                throw new Error('Gagal memuat halaman.');
            }

            return response.text();

        })

        .then(function (html) {

            /*
            |--------------------------------------------------------------------------
            | PARSE HALAMAN
            |--------------------------------------------------------------------------
            */

            const parser = new DOMParser();

            const doc = parser.parseFromString(
                html,
                'text/html'
            );

            const newTable =
                doc.getElementById('tableContainer');


            if (!newTable) {

                throw new Error(
                    'tableContainer tidak ditemukan.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | GANTI ISI TABEL
            |--------------------------------------------------------------------------
            */

            tableContainer.innerHTML =
                newTable.innerHTML;


            /*
            |--------------------------------------------------------------------------
            | UPDATE URL
            |--------------------------------------------------------------------------
            */

            window.history.pushState(
                {},
                '',
                url
            );


            /*
            |--------------------------------------------------------------------------
            | ANIMASI MASUK
            |--------------------------------------------------------------------------
            */

            tableContainer.style.opacity = '0';

            tableContainer.style.transform =
                'translateX(-30px)';


            requestAnimationFrame(function () {

                tableContainer.style.opacity = '1';

                tableContainer.style.transform =
                    'translateX(0)';

            });


            /*
            |--------------------------------------------------------------------------
            | AKTIFKAN PAGINATION BARU
            |--------------------------------------------------------------------------
            */

            initPagination();

        })

        .catch(function (error) {

            console.error(
                'Pagination error:',
                error
            );

            /*
            | Kalau AJAX gagal,
            | jangan biarkan tabel transparan.
            */

            tableContainer.style.opacity = '1';

            tableContainer.style.transform =
                'translateX(0)';

        });

    }


    /*
    |--------------------------------------------------------------------------
    | BACK / FORWARD BROWSER
    |--------------------------------------------------------------------------
    */

    window.addEventListener('popstate', function () {

        loadPage(
            window.location.href
        );

    });


    /*
    |--------------------------------------------------------------------------
    | INIT
    |--------------------------------------------------------------------------
    */

    initPagination();

});
</script>
@endsection