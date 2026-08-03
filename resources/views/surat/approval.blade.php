@extends('layouts.app')

@section('title', 'Approval Surat')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">

        <div>

            <h1 class="flex items-center gap-3 text-4xl font-black text-slate-800">
                <i data-lucide="shield-check" class="w-10 h-10 text-indigo-600"></i>
                Approval Surat
            </h1>

            <p class="mt-3 text-slate-500 text-lg">
                Kelola proses persetujuan surat MERPATI TVRI NTB
            </p>

        </div>

        <div class="flex items-center gap-3">

            <div class="px-5 py-3 rounded-2xl bg-indigo-50 border border-indigo-100">
                <p class="text-xs uppercase tracking-wider text-indigo-500 font-bold">
                    Hari Ini
                </p>

                <p class="font-black text-slate-700">
                    {{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>

        </div>

    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

        {{-- TOTAL --}}
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 to-cyan-500 text-white shadow-xl p-7">

            <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white/10"></div>

            <div class="relative z-10 flex justify-between items-start">

                <div>

                    <p class="text-white/80 font-semibold">
                        Total Surat
                    </p>

                    <h2 class="text-5xl font-black mt-2">
                        {{ $totalSurat }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">

                    <i data-lucide="files" class="w-8 h-8"></i>

                </div>

            </div>

        </div>

        {{-- MENUNGGU --}}
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-amber-500 to-orange-400 text-white shadow-xl p-7">

            <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white/10"></div>

            <div class="relative z-10 flex justify-between items-start">

                <div>

                    <p class="text-white/80 font-semibold">
                        Menunggu
                    </p>

                    <h2 class="text-5xl font-black mt-2">
                        {{ $menunggu }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">

                    <i data-lucide="clock-3" class="w-8 h-8"></i>

                </div>

            </div>

        </div>

        {{-- DISETUJUI --}}
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 to-green-500 text-white shadow-xl p-7">

            <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white/10"></div>

            <div class="relative z-10 flex justify-between items-start">

                <div>

                    <p class="text-white/80 font-semibold">
                        Disetujui
                    </p>

                    <h2 class="text-5xl font-black mt-2">
                        {{ $disetujui }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">

                    <i data-lucide="circle-check-big" class="w-8 h-8"></i>

                </div>

            </div>

        </div>

        {{-- DITOLAK --}}
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-red-500 to-rose-600 text-white shadow-xl p-7">

            <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white/10"></div>

            <div class="relative z-10 flex justify-between items-start">

                <div>

                    <p class="text-white/80 font-semibold">
                        Ditolak
                    </p>

                    <h2 class="text-5xl font-black mt-2">
                        {{ $ditolak }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">

                    <i data-lucide="circle-x" class="w-8 h-8"></i>

                </div>

            </div>

        </div>

    </div>

        {{-- SEARCH & FILTER --}}
    <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-6 mb-8">

        <form method="GET" action="{{ route('surat.approval') }}">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-2  ">

                {{-- SEARCH --}}
                <div class="lg:col-span-4">

                    <div class="relative">

                        <i data-lucide="search"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nomor surat, perihal, atau pengirim..."
                            class="w-full rounded-2xl border-slate-300 pl-12 pr-4 py-3 focus:ring-2 focus:ring-indigo-500">

                    </div>

                </div>

                {{-- STATUS --}}
<div class="lg:col-span-3">

    <select
        name="status"
        class="w-full rounded-2xl border-slate-300 py-3">

        <option value="">Semua Status</option>

        <option
            value="Menunggu Approval"
            {{ request('status') == 'Menunggu Approval' ? 'selected' : '' }}>
            Menunggu Approval
        </option>

        <option
            value="Disetujui"
            {{ request('status') == 'Disetujui' ? 'selected' : '' }}>
            Disetujui
        </option>

        <option
            value="Ditolak"
            {{ request('status') == 'Ditolak' ? 'selected' : '' }}>
            Ditolak
        </option>

    </select>

</div>
                {{-- BUTTON --}}
                <div class="lg:col-span-4 flex gap-3">

                    <button
                        class="flex-1 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 transition">

                        <i data-lucide="search" class="w-5 h-5 inline"></i>

                        Cari

                    </button>

                    <a
                        href="{{ route('surat.approval') }}"
                        class="px-6 rounded-2xl border border-slate-300 hover:bg-slate-100 flex items-center justify-center">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>


    {{-- LIST SURAT --}}
    <div class="space-y-7">

        @forelse($surat as $item)

        @php

        $currentApproval = $item->approval
            ->where('approver_id', auth()->id())
            ->where('status','Menunggu')
            ->first();

        @endphp

@php

$status = $item->status;

$badgeColor = 'bg-yellow-100 text-yellow-700';
$badgeIcon  = 'clock-3';

switch ($status) {

    case 'Disetujui':
        $badgeColor = 'bg-green-100 text-green-700';
        $badgeIcon  = 'circle-check-big';
        break;

    case 'Ditolak':
        $badgeColor = 'bg-red-100 text-red-700';
        $badgeIcon  = 'circle-x';
        break;

    case 'Menunggu Approval':
        $badgeColor = 'bg-yellow-100 text-yellow-700';
        $badgeIcon  = 'clock-3';
        break;

}

@endphp
        <div
            class="bg-white rounded-3xl border border-slate-200 shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">

            <div class="p-8 space-y-8">

                <div class="flex flex-col xl:flex-row xl:justify-between gap-10">

                    <div class="flex-1">

                        <h2 class="text-2xl font-black text-slate-800">

                            {{ $item->perihal }}

                        </h2>

                        <div class="grid md:grid-cols-2 gap-x-10 gap-y-6 mt-8">

                            <div>

                                <p class="text-slate-400 text-sm">
                                    Nomor Surat
                                </p>

                                <p class="font-bold text-slate-700">
                                    {{ $item->nomor_surat }}
                                </p>

                            </div>

                            <div>

                                <p class="text-slate-400 text-sm">
                                    Pengirim
                                </p>

                                <p class="font-bold text-slate-700">
                                    {{ $item->pengirim->name ?? '-' }}
                                </p>

                            </div>

                            <div>

                                <p class="text-slate-400 text-sm">
                                    Tanggal
                                </p>

                                <p class="font-bold text-slate-700">
                                    {{ $item->created_at->translatedFormat('d F Y') }}
                                </p>

                            </div>

                            <div>

                                <p class="text-slate-400 text-sm">
                                        Status
                                    </p>

                                    @php

                                    $currentApproval = $item->approval
                                        ->where('status', 'Menunggu')
                                        ->sortBy('urutan')
                                        ->first();

                                    $statusLabel = $status;

                                    if ($currentApproval) {

                                        $statusLabel = 'Menunggu ' .
                                        (
                                            $currentApproval->workflow?->jabatan?->nama_jabatan
                                            ?? '-'
                                        );
                                    }

                                    @endphp

                                    <span
                                        class="inline-flex items-center
                                            gap-2
                                            px-3 py-2
                                            rounded-full
                                            text-sm
                                            font-semibold
                                            max-w-[240px]
                                            truncate
                                            {{ $badgeColor }}">

                                        <i
                                            data-lucide="{{ $badgeIcon }}"
                                            class="w-4 h-4 shrink-0">
                                        </i>

                                        <span class="truncate">
                                            {{ $statusLabel }}
                                        </span>

                                    </span>

                            </div>

                        </div>

                    </div>

                    <div class="mt-10 pt-8 border-t border-slate-200">

    <h4 class="font-bold text-slate-700 mb-6">
        Progress Approval
    </h4>
    
<div class="flex items-center">

@php

$workflows = $item->jenisSurat?->approvalWorkflows ?? collect();

@endphp

@foreach($workflows as $workflow)

    @php

$approval = $item->approval->firstWhere(
    'approval_workflow_id',
    $workflow->id
);

$iconBg = 'bg-slate-200 text-slate-500';
$icon   = 'circle';

/*
|--------------------------------------------------------------------------
| Jabatan pengirim dianggap otomatis selesai
|--------------------------------------------------------------------------
*/

if (
    $workflow->jabatan_id == $item->pengirim->jabatan_id
) {

    $iconBg = 'bg-green-500 text-white';
    $icon   = 'check';

}

/*
|--------------------------------------------------------------------------
| Approval yang benar-benar ada
|--------------------------------------------------------------------------
*/

elseif ($approval) {

    if ($approval->status == 'Disetujui') {

        $iconBg = 'bg-green-500 text-white';
        $icon = 'check';

    } elseif ($approval->status == 'Ditolak') {

        $iconBg = 'bg-red-500 text-white';
        $icon = 'x';

    } elseif ($approval->status == 'Menunggu') {

        $iconBg = 'bg-amber-400 text-white';
        $icon = 'hourglass';

    }

}   

    @endphp

    <div class="flex flex-col items-center">

        <div class="w-9 h-9 rounded-full flex items-center justify-center {{ $iconBg }}">
            <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
        </div>

        <span class="mt-2 text-[10px] font-medium text-slate-600 text-center max-w-[70px] leading-tight">

            {{ Str::words($workflow->jabatan?->nama_jabatan ?? '-', 2, '') }}

        </span>

    </div>

    @if(!$loop->last)
        <div class="w-6 h-0.5 bg-slate-300 mx-2"></div>
    @endif

@endforeach

@if($workflows->isNotEmpty())

    <div class="w-6 h-0.5 bg-slate-300 mx-2"></div>

@endif
<div class="flex flex-col items-center">

    <div
        class="w-9 h-9 rounded-full
               flex items-center justify-center

               {{ $item->status=='Disetujui'
                    ? 'bg-green-500 text-white'
                    : 'bg-slate-200 text-slate-500' }}">

        <i
            data-lucide="badge-check"
            class="w-4 h-4">
        </i>

    </div>

    <span
        class="mt-2
               text-[10px]
               font-medium
               text-slate-600">

        Final

    </span>

</div>

</div>

</div>

{{-- ACTION --}}
<div class="mt-10 pt-8 border-t border-slate-200 flex flex-wrap items-center gap-3">

    {{-- Detail --}}
    <a
        href="{{ route('surat.detail', $item->id) }}"
        title="Lihat Detail"
        class="w-11 h-11 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition">

        <i data-lucide="eye" class="w-5 h-5"></i>

    </a>

    @if($currentApproval)

        {{-- Setujui --}}
        <form
            method="POST"
            action="{{ route('approval.approve', $item->id) }}">

            @csrf

            <button
                type="submit"
                title="Setujui Surat"
                class="w-11 h-11 rounded-xl bg-green-600 hover:bg-green-700 text-white flex items-center justify-center transition">

                <i data-lucide="check" class="w-5 h-5"></i>

            </button>

        </form>

        {{-- Tolak --}}
        <form
            method="POST"
            action="{{ route('approval.reject', $item->id) }}">

            @csrf

            <button
                type="submit"
                title="Tolak Surat"
                class="w-11 h-11 rounded-xl bg-red-600 hover:bg-red-700 text-white flex items-center justify-center transition">

                <i data-lucide="x" class="w-5 h-5"></i>

            </button>

        </form>

    @endif

</div>

            </div>
        
        </div>

     @empty

        <div class="bg-white rounded-3xl border border-slate-200 shadow-lg p-16 text-center">

            <i data-lucide="inbox" class="w-16 h-16 mx-auto text-slate-300"></i>

            <h3 class="mt-4 text-2xl font-bold text-slate-700">
                Tidak ada surat
            </h3>

            <p class="mt-2 text-slate-500">
                Belum ada surat yang perlu diproses.
            </p>

        </div>

    @endforelse

</div>

@endsection