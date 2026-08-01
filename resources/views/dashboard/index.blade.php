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
p-10
text-white
shadow-2xl
">


<div class="
absolute
-top-20
-right-20
w-72
h-72
bg-white/20
rounded-full
blur-3xl
">
</div>



<div class="
absolute
bottom-0
left-0
w-60
h-60
bg-cyan-200/20
rounded-full
blur-3xl
">
</div>





<div class="
relative
flex
justify-between
items-center
">


<div>







<h1 class="
text-5xl
font-black
mt-3
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






{{-- BURUNG TERBANG --}}

<div class="
hidden
lg:flex
text-[140px]
flying-bird
">


<div class="bird">

🕊️

</div>


</div>




</div>


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
mt-10
w-full
bg-white
rounded-[32px]
p-10
shadow-lg
">


{{-- HEADER --}}

<div class="
flex
items-center
gap-4
mb-8
">


<div class="flex items-center gap-4">

    <div class="
    w-12
    h-12
    rounded-2xl
    bg-blue-100
    flex
    items-center
    justify-center
    ">

        <i data-lucide="activity"
        class="
        w-6
        h-6
        text-blue-600
        ">
        </i>

    </div>


    <h2 class="
    text-3xl
    font-black
    text-slate-800
    ">
        Aktivitas Terbaru
    </h2>


</div>


</div>





<div class="
space-y-4
">


@forelse($aktivitas as $item)



<div class="
flex
items-center
justify-between
bg-slate-50
hover:bg-blue-50
transition
p-5
rounded-2xl
">



<div>


<p class="
font-bold
text-slate-800
">

{{ $item['judul'] }}

</p>



<p class="
text-sm
text-slate-500
mt-1
">

{{ $item['deskripsi'] }}

</p>



<p class="
text-xs
text-slate-400
mt-2
">

{{ $item['waktu']->diffForHumans() }}

</p>



</div>





<span
class="
px-4
py-2
rounded-xl
font-bold
text-sm


@if($item['status'] == 'Baru')
bg-blue-100 text-blue-600

@elseif($item['status'] == 'Menunggu')
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


</div>



@empty



<div class="
text-center
py-12
">


<div class="
w-16
h-16
mx-auto
mb-4
rounded-2xl
bg-blue-100
flex
items-center
justify-center
">


<i data-lucide="inbox"
class="
w-8
h-8
text-blue-700
">
</i>


</div>



<p class="
font-bold
text-slate-700
text-lg
">

Belum ada aktivitas terbaru.

</p>



<p class="
text-sm
text-slate-400
mt-2
">

Aktivitas surat akan muncul di sini.

</p>


</div>


@endforelse


</div>


</div>






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



@endsection