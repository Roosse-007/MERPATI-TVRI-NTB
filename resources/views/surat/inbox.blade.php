@extends('layouts.app')

@section('title','Kotak Masuk')

@section('content')


{{-- HEADER --}}
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">


<div>

<h1 class="text-4xl font-black text-slate-800">
    Kotak Masuk
</h1>

<p class="text-slate-500 mt-2">
    Daftar surat masuk yang diterima oleh unit kerja
</p>

</div>



<a href="{{ route('surat.create') }}"
class="
inline-flex
items-center
justify-center
bg-gradient-to-r
from-blue-600
to-cyan-400
text-white
px-7
py-3
rounded-2xl
font-bold
shadow-lg
hover:scale-105
transition">

+ Surat Baru

</a>


</div>



{{-- STAT CARD --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">


    {{-- TOTAL SURAT --}}
    <div class="
        relative
        overflow-hidden
        rounded-3xl
        p-6
        text-white
        shadow-xl
        bg-gradient-to-br
        from-blue-600
        to-cyan-400
        hover:-translate-y-1
        transition
        duration-300
    ">

        <div class="absolute -right-10 -top-10
            w-32 h-32
            bg-white/10
            rounded-full">
        </div>


        <div class="flex items-center justify-between">


            <div>

                <p class="text-white/80 font-medium">
                    Total Surat
                </p>


                <h2 class="text-5xl font-black mt-3">
                    {{ $totalSurat }}
                </h2>


                <p class="text-sm text-white/80 mt-4">
                    Jumlah surat masuk
                </p>

            </div>



            <div class="
                w-16
                h-16
                rounded-2xl
                bg-white/20
                backdrop-blur
                flex
                items-center
                justify-center
                text-3xl
                shadow-inner
            ">

                <i class="bi bi-envelope-paper-fill"></i>

            </div>


        </div>

    </div>






    {{-- MENUNGGU APPROVAL --}}
    <div class="
        relative
        overflow-hidden
        rounded-3xl
        p-6
        text-white
        shadow-xl
        bg-gradient-to-br
        from-amber-500
        to-orange-400
        hover:-translate-y-1
        transition
        duration-300
    ">


        <div class="absolute -right-10 -top-10
            w-32 h-32
            bg-white/10
            rounded-full">
        </div>



        <div class="flex items-center justify-between">


            <div>

                <p class="text-white/80 font-medium">
                    Menunggu Approval
                </p>


                <h2 class="text-5xl font-black mt-3">
                    {{ $menungguApproval }}
                </h2>


                <p class="text-sm text-white/80 mt-4">
                    Surat menunggu persetujuan
                </p>


            </div>



            <div class="
                w-16
                h-16
                rounded-2xl
                bg-white/20
                backdrop-blur
                flex
                items-center
                justify-center
                text-3xl
            ">

                <i class="bi bi-clock-history"></i>

            </div>


        </div>


    </div>








    {{-- DITOLAK --}}
    <div class="
        relative
        overflow-hidden
        rounded-3xl
        p-6
        text-white
        shadow-xl
        bg-gradient-to-br
        from-red-500
        to-rose-600
        hover:-translate-y-1
        transition
        duration-300
    ">


        <div class="absolute -right-10 -top-10
            w-32 h-32
            bg-white/10
            rounded-full">
        </div>



        <div class="flex items-center justify-between">


            <div>

                <p class="text-white/80 font-medium">
                    Ditolak
                </p>


                <h2 class="text-5xl font-black mt-3">
                    {{ $ditolak }}
                </h2>


                <p class="text-sm text-white/80 mt-4">
                    Surat yang ditolak
                </p>


            </div>




            <div class="
                w-16
                h-16
                rounded-2xl
                bg-white/20
                backdrop-blur
                flex
                items-center
                justify-center
                text-3xl
            ">

                <i class="bi bi-file-earmark-x-fill"></i>

            </div>


        </div>


    </div>









    {{-- DISPOSISI --}}
    <div class="
        relative
        overflow-hidden
        rounded-3xl
        p-6
        text-white
        shadow-xl
        bg-gradient-to-br
        from-purple-600
        to-indigo-500
        hover:-translate-y-1
        transition
        duration-300
    ">


        <div class="absolute -right-10 -top-10
            w-32 h-32
            bg-white/10
            rounded-full">
        </div>




        <div class="flex items-center justify-between">


            <div>

                <p class="text-white/80 font-medium">
                    Disposisi
                </p>


                <h2 class="text-5xl font-black mt-3">
                    {{ $disposisi }}
                </h2>


                <p class="text-sm text-white/80 mt-4">
                    Surat yang didisposisi
                </p>


            </div>




            <div class="
                w-16
                h-16
                rounded-2xl
                bg-white/20
                backdrop-blur
                flex
                items-center
                justify-center
                text-3xl
            ">

                <i class="bi bi-diagram-3-fill"></i>

            </div>


        </div>


    </div>



</div>


{{-- SEARCH FILTER --}}

<form
id="searchForm"
method="GET"
action="{{ route('surat.inbox') }}"
class="mt-10 bg-white rounded-[28px] p-6 shadow-lg">

<div class="flex flex-col md:flex-row gap-4">

<input
id="searchInput"
type="text"
name="search"
value="{{ request('search') }}"
placeholder="Cari nomor surat, perihal, atau pengirim..."
class="flex-1 bg-slate-100 rounded-2xl px-5 py-4 outline-none focus:ring-2 focus:ring-blue-500">

<select
id="statusFilter"
name="status"
class="bg-slate-100 rounded-2xl px-5 py-4 outline-none">

    <option value="">Semua Status</option>

    <option value="Draft"
        @selected(request('status')=='Draft')>
        Draft
    </option>

    <option value="Menunggu Approval KPP"
        @selected(request('status')=='Menunggu Approval KPP')>
        Menunggu Approval KPP
    </option>

    <option value="Menunggu Approval KTU"
        @selected(request('status')=='Menunggu Approval KTU')>
        Menunggu Approval KTU
    </option>

    <option value="Menunggu Approval Kepala Stasiun"
        @selected(request('status')=='Menunggu Approval Kepala Stasiun')>
        Menunggu Approval Kepala Stasiun
    </option>

    <option value="Disetujui"
        @selected(request('status')=='Disetujui')>
        Disetujui
    </option>

    <option value="Ditolak"
        @selected(request('status')=='Ditolak')>
        Ditolak
    </option>

</select>

<button
type="submit"
class="bg-blue-600 text-white px-6 rounded-2xl hover:bg-blue-700 transition">

Cari

</button>

</div>

</form>






{{-- LIST SURAT --}}

<div class="
mt-8
space-y-5
">


@forelse($surat as $item)



<div class="
bg-white
rounded-[28px]
p-6
shadow-lg
hover:-translate-y-1
transition
">


<div class="
flex
items-center
justify-between
">


<div class="flex gap-5 items-center">


<div class="
w-14
h-14
rounded-2xl
bg-blue-100
flex
items-center
justify-center
text-2xl
">

📩

</div>


<div>


<h3 class="font-black text-xl text-slate-800">
    {{ $item->perihal }}
</h3>

<p class="text-sm text-slate-500 mt-1">
    Nomor Surat :
    <span class="font-semibold text-slate-700">
        {{ $item->nomor_surat ?? '-' }}
    </span>
</p>

<p class="text-sm text-slate-500">
    Jenis Surat :
    <span class="font-medium text-slate-700">
        {{ $item->jenisSurat->nama ?? '-' }}
    </span>
</p>

<p class="text-slate-500 mt-2">
    <span class="font-medium">Pengirim :</span>
    {{ $item->pengirim->name ?? '-' }}
</p>

<p class="text-sm text-slate-400 mt-1">
    <span class="font-medium">Tanggal :</span>
    {{ $item->tanggal_surat
        ? \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d F Y')
        : '-' }}
</p>


</div>


</div>





<span class="
px-4
py-2
rounded-xl
font-bold
text-sm

@if($item->status=='Draft')

bg-gray-100 text-gray-700

@elseif($item->status=='Menunggu Approval KPP')

bg-yellow-100 text-yellow-700

@elseif($item->status=='Menunggu Approval KTU')

bg-orange-100 text-orange-700

@elseif($item->status=='Menunggu Approval Kepala Stasiun')

bg-indigo-100 text-indigo-700

@elseif($item->status=='Disetujui')

bg-green-100 text-green-700

@elseif($item->status=='Ditolak')

bg-red-100 text-red-700

@else

bg-slate-100 text-slate-700

@endif

">


{{ $item->status }}


</span>



</div>




<div class="mt-5 flex gap-3">

    <a
    href="{{ route('surat.detail',$item->id) }}"
    class="px-5 py-2 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition">
        Lihat
    </a>

    @if($item->file_surat)

        <a
        href="{{ asset('storage/'.$item->file_surat) }}"
        download
        class="px-5 py-2 rounded-xl bg-slate-100 font-bold hover:bg-slate-200 transition">
            Download
        </a>

    @else

        <button
        disabled
        class="px-5 py-2 rounded-xl bg-slate-200 text-slate-400 cursor-not-allowed">
            Tidak Ada File
        </button>

    @endif

</div>


</div>


@empty

<div class="bg-white rounded-3xl p-10 text-center shadow-lg">

<div class="text-6xl">📭</div>

<h2 class="text-2xl font-bold mt-5">
Tidak ada surat
</h2>

<p class="text-slate-500 mt-2">
Belum ada data surat.
</p>

</div>

@endforelse


</div>

<div class="mt-8 flex justify-center">
    {{ $surat->links() }}
</div>

<script>
const form = document.getElementById('searchForm');
const search = document.getElementById('searchInput');
const status = document.getElementById('statusFilter');

let timer;

search.addEventListener('input', function () {

    clearTimeout(timer);

    timer = setTimeout(function () {
        form.submit();
    }, 500);

});

status.addEventListener('change', function () {
    form.submit();
});
</script>


@endsection