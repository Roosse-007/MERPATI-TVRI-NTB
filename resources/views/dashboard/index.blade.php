@extends('layouts.app')

@section('title','Dashboard')

@section('content')

{{-- HERO SECTION --}}
<section class="
relative
overflow-hidden
rounded-[32px]
bg-gradient-to-br
from-blue-700
via-blue-600
to-cyan-400
h-72
px-10
flex
items-center
shadow-2xl
">


{{-- TEXT --}}
<div class="relative z-10">

<h1 class="
text-5xl
font-black
text-white
tracking-wide
">
MERPATI TVRI NTB
</h1>


<p class="
mt-4
text-xl
font-semibold
text-blue-100
">
Manajemen Elektronik Registrasi Surat dan Pengiriman Antar Tim
</p>


</div>



{{-- BURUNG --}}
<img
src="{{ asset('image/merpati-surat.png') }}"
class="
absolute
right-16
bottom-6
w-100
drop-shadow-2xl
dove-animation
"
/>


</section>

{{-- STATISTIC CARD --}}

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mt-10">

    {{-- SURAT MASUK --}}
   <a href="/inbox"
class="
    block
    relative
    overflow-hidden
    rounded-3xl
    p-6
    text-white
    shadow-xl
    bg-gradient-to-br
    from-sky-600
    to-blue-500
    hover:-translate-y-1
    hover:shadow-2xl
    transition-all
    duration-300
">

        <div class="
            absolute
            -right-10
            -top-10
            w-32
            h-32
            bg-white/10
            rounded-full">
        </div>

        <div class="flex items-center justify-between">

            <div>

                <p class="text-white/80 font-medium">
                    Surat Masuk
                </p>

                <h2 class="text-5xl font-black mt-3">
                    {{ $suratMasuk ?? 0 }}
                </h2>

                <p class="text-sm text-white/80 mt-4">
                    Total surat diterima
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
            ">

                <i data-lucide="mail" class="w-8 h-8"></i>

            </div>

        </div>

    </a>



    {{-- DRAFT --}}
<a href="/surat/draft"
class="
    block
    relative
    overflow-hidden
    rounded-3xl
    p-6
    text-white
    shadow-xl
    bg-gradient-to-br
    from-violet-600
    to-fuchsia-500
    hover:-translate-y-1
    hover:shadow-2xl
    transition-all
    duration-300
">

        <div class="
            absolute
            -right-10
            -top-10
            w-32
            h-32
            bg-white/10
            rounded-full">
        </div>

        <div class="flex items-center justify-between">

            <div>

                <p class="text-white/80 font-medium">
                    Draft
                </p>

                <h2 class="text-5xl font-black mt-3">
                    {{ $draft ?? 0 }}
                </h2>

                <p class="text-sm text-white/80 mt-4">
                    Surat masih draft
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
            ">

                <i data-lucide="file-pen-line" class="w-8 h-8"></i>

            </div>

        </div>

    </a>



    {{-- APPROVAL --}}
    <a href="/surat/approval"
class="
    block
    relative
    overflow-hidden
    rounded-3xl
    p-6
    text-white
    shadow-xl
    bg-gradient-to-br
    from-emerald-600
    to-green-500
    hover:-translate-y-1
    hover:shadow-2xl
    transition-all
    duration-300
">

        <div class="
            absolute
            -right-10
            -top-10
            w-32
            h-32
            bg-white/10
            rounded-full">
        </div>

        <div class="flex items-center justify-between">

            <div>

                <p class="text-white/80 font-medium">
                    Approval
                </p>

                <h2 class="text-5xl font-black mt-3">
                    {{ $approval ?? 0 }}
                </h2>

                <p class="text-sm text-white/80 mt-4">
                    Surat telah disetujui
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
            ">

                <i data-lucide="badge-check" class="w-8 h-8"></i>

            </div>

        </div>

    </a>



    {{-- ARSIP --}}

<a href="/surat/arsip"
class="
    block
    relative
    overflow-hidden
    rounded-3xl
    p-6
    text-white
    shadow-xl
    bg-gradient-to-br
    from-orange-500
    to-amber-400
    hover:-translate-y-1
    hover:shadow-2xl
    transition-all
    duration-300
">

        <div class="
            absolute
            -right-10
            -top-10
            w-32
            h-32
            bg-white/10
            rounded-full">
        </div>

        <div class="flex items-center justify-between">

            <div>

                <p class="text-white/80 font-medium">
                    Arsip
                </p>

                <h2 class="text-5xl font-black mt-3">
                    {{ $arsip ?? 0 }}
                </h2>

                <p class="text-sm text-white/80 mt-4">
                    Surat telah diarsipkan
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
            ">

                <i data-lucide="archive" class="w-8 h-8"></i>

            </div>

        </div>

    </a>
    
</div>


{{-- AKTIVITAS TERBARU --}}

<div class="
bg-white
rounded-[32px]
p-8
shadow-lg
mt-10
">


    {{-- HEADER --}}

    <div class="
    flex
    items-center
    justify-between
    mb-6
    ">


        <h2 class="
        text-2xl
        font-black
        text-slate-800
        ">
            Aktivitas Terbaru
        </h2>



        <div class="relative">


            <i class="bi bi-search 
            absolute 
            left-4 
            top-1/2 
            -translate-y-1/2
            text-slate-400">
            </i>



            <input
            id="searchAktivitas"
            type="text"
            placeholder="Cari aktivitas..."
            class="
            w-52
            pl-11
            pr-4
            py-2
            rounded-xl
            bg-slate-100
            text-sm
            focus:outline-none
            "
            >


        </div>


    </div>

<div id="aktivitas-container">

    {{-- TABLE --}}

    <div class="
    overflow-hidden
    rounded-2xl
    border
    ">


        <table class="w-full">


            <thead class="
            bg-gradient-to-r
            from-blue-600
            to-cyan-500
            text-white
            ">

                <tr>

                    <th class="px-5 py-4 text-left">
                        No
                    </th>

                    <th class="px-5 py-4 text-left">
                        Aktivitas
                    </th>

                    <th class="px-5 py-4 text-left">
                        Deskripsi
                    </th>

                    <th class="px-5 py-4 text-left">
                        Waktu
                    </th>

                    <th class="px-5 py-4 text-left">
                        Status
                    </th>

                </tr>

            </thead>



            <tbody>


            @foreach($aktivitas as $index=>$item)


            <tr class="
            aktivitas-row
            border-b
            hover:bg-blue-50
            transition
            ">


                <td class="px-5 py-5">


<div class="
w-9
h-9
rounded-full
bg-blue-100
text-blue-600
flex
items-center
justify-center
font-bold
">


{{ $index+1 }}


</div>


</td>



                <td class="px-5 py-5">

    <div class="flex items-center gap-4">


        {{-- ICON AKTIVITAS --}}
        <div class="
            w-10
            h-10
            rounded-xl
            bg-gradient-to-br
            from-blue-500
            to-cyan-400
            flex
            items-center
            justify-center
            shadow-md
        ">

            <i data-lucide="mail"
            class="
            w-5
            h-5
            text-white
            ">
            </i>

        </div>



        {{-- JUDUL --}}
        <span class="
        font-bold
        text-slate-800
        ">

            {{ $item['judul'] }}

        </span>


    </div>

</td>



                <td class="px-5 py-5 text-slate-500">

                    {{ $item['deskripsi'] }}

                </td>



                <td class="px-5 py-5 text-slate-500">

                    {{ $item['waktu']->timezone('Asia/Makassar')->format('d M Y, H:i') }}

                </td>



                <td class="px-5 py-5">


<span
class="
px-4
py-2
rounded-full
text-xs
font-bold

@if($item['status'] == 'Baru')

bg-blue-100 text-blue-600


@elseif($item['status'] == 'Menunggu Approval KPP' 
|| $item['status'] == 'Menunggu')

bg-yellow-100 text-yellow-700


@elseif($item['status'] == 'Disetujui')

bg-green-100 text-green-700


@elseif($item['status'] == 'Ditolak')

bg-red-100 text-red-700


@elseif($item['status'] == 'Disposisi')

bg-purple-100 text-purple-700


@elseif($item['status'] == 'Arsip')

bg-orange-100 text-orange-700


@else

bg-gray-100 text-gray-700


@endif
">


{{ $item['status'] }}


</span>


</td>


            </tr>


            @endforeach


            </tbody>


        </table>


    </div>


</div>



<div class="flex justify-center items-center gap-3 mt-8 mb-6">

    {{-- Previous --}}
    @if ($aktivitas->onFirstPage())

        <span class="
        w-11 h-11
        rounded-xl
        bg-slate-200
        text-slate-400
        flex
        items-center
        justify-center
        ">
            ←
        </span>

    @else

        <a href="{{ $aktivitas->previousPageUrl() }}"
        class="
        w-11 h-11
        rounded-xl
        bg-white
        shadow
        hover:bg-blue-600
        hover:text-white
        flex
        items-center
        justify-center
        transition
        ">
            ←
        </a>

    @endif



    {{-- Nomor halaman --}}
    @for ($i = 1; $i <= $aktivitas->lastPage(); $i++)

        <a href="{{ $aktivitas->url($i) }}"
        class="
        w-11 h-11
        rounded-xl
        flex
        items-center
        justify-center
        font-bold
        transition

        {{ $aktivitas->currentPage() == $i
            ? 'bg-blue-600 text-white shadow-lg'
            : 'bg-white text-slate-600 hover:bg-blue-100'
        }}
        ">

            {{ $i }}

        </a>

    @endfor



    {{-- Next --}}
    @if ($aktivitas->hasMorePages())

        <a href="{{ $aktivitas->nextPageUrl() }}"
        class="
        w-11 h-11
        rounded-xl
        bg-white
        shadow
        hover:bg-blue-600
        hover:text-white
        flex
        items-center
        justify-center
        transition
        ">
            →
        </a>

    @else

        <span class="
        w-11 h-11
        rounded-xl
        bg-slate-200
        text-slate-400
        flex
        items-center
        justify-center
        ">
            →
        </span>

    @endif

</div>

</div> {{-- aktivitas-container --}}


<style>
    

.flying-bird{

animation: fly 5s ease-in-out infinite;

}



@keyframes fly{


0%{

transform:
translateX(0)
translateY(0)
rotate(-8deg);

}



20%{

transform:
translateX(-20px)
translateY(-12px)
rotate(-4deg);

}



40%{

transform:
translateX(15px)
translateY(-20px)
rotate(4deg);

}



60%{

transform:
translateX(-10px)
translateY(-8px)
rotate(-2deg);

}



80%{

transform:
translateX(20px)
translateY(-15px)
rotate(5deg);

}



100%{

transform:
translateX(0)
translateY(0)
rotate(-8deg);

}



}


</style>

<script>

const searchInput = document.getElementById('searchAktivitas');

searchInput.addEventListener('input', function () {

    let keyword = this.value.toLowerCase();


    let rows = document.querySelectorAll('.aktivitas-row');


    rows.forEach(row => {


        let data = row.innerText.toLowerCase();


        if(data.includes(keyword)) {

            row.style.display = '';

        } else {

            row.style.display = 'none';

        }


    });


});

</script>



@endsection

