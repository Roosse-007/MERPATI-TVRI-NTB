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


<p class="
text-blue-100
text-lg
">

Selamat Datang 👋

</p>




<h1 class="
text-5xl
font-black
mt-3
">

Sistem E-Surat
<br>
MERPATI TVRI NTB

</h1>




<p class="
mt-5
text-blue-100
max-w-xl
">

Kelola surat masuk, surat keluar,
approval dan disposisi dengan sistem
digital yang cepat dan modern.

</p>




<a href="/surat/create"

class="
inline-block
mt-8
bg-white
text-slate-900
px-8
py-3
rounded-2xl
font-bold
shadow-xl
hover:scale-105
hover:bg-blue-50
transition
">

Mulai Kelola Surat

</a>


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


<div class="
grid
grid-cols-1
md:grid-cols-2
xl:grid-cols-4
gap-6
mt-10
">






{{-- SURAT MASUK --}}

<div class="
rounded-[28px]
bg-white
p-7
shadow-lg
hover:-translate-y-2
transition
border
border-blue-100
">


<div class="
w-14
h-14
rounded-2xl
bg-blue-100
flex
items-center
justify-center
text-3xl
">

📩

</div>



<p class="
mt-5
text-slate-500
">

Surat Masuk

</p>



<h2 class="
text-4xl
font-black
text-slate-800
">

{{ $suratMasuk ?? 0 }}

</h2>


</div>







{{-- DRAFT --}}


<div class="
rounded-[28px]
bg-white
p-7
shadow-lg
hover:-translate-y-2
transition
border
border-purple-100
">


<div class="
w-14
h-14
rounded-2xl
bg-purple-100
flex
items-center
justify-center
text-3xl
">

📝

</div>


<p class="
mt-5
text-slate-500
">

Draft

</p>



<h2 class="
text-4xl
font-black
">

{{ $draft ?? 0 }}

</h2>


</div>







{{-- APPROVAL --}}


<div class="
rounded-[28px]
bg-white
p-7
shadow-lg
hover:-translate-y-2
transition
border
border-green-100
">


<div class="
w-14
h-14
rounded-2xl
bg-green-100
flex
items-center
justify-center
text-3xl
">

✅

</div>


<p class="
mt-5
text-slate-500
">

Approval

</p>


<h2 class="
text-4xl
font-black
">

{{ $approval ?? 0 }}

</h2>


</div>








{{-- ARSIP --}}


<div class="
rounded-[28px]
bg-white
p-7
shadow-lg
hover:-translate-y-2
transition
border
border-orange-100
">


<div class="
w-14
h-14
rounded-2xl
bg-orange-100
flex
items-center
justify-center
text-3xl
">

🗄️

</div>



<p class="
mt-5
text-slate-500
">

Arsip

</p>



<h2 class="
text-4xl
font-black
">

{{ $arsip ?? 0 }}

</h2>


</div>



</div>








{{-- AKTIVITAS TERBARU --}}

<div class="
mt-10
bg-white
rounded-[32px]
p-8
shadow-lg
">

    <h2 class="
    text-2xl
    font-black
    text-slate-800
    ">
        Aktivitas Terbaru
    </h2>

    <div class="
    mt-6
    space-y-4
    ">

        @forelse($aktivitas as $item)

            <div class="
            flex
            items-center
            justify-between
            bg-slate-50
            p-5
            rounded-2xl
            ">

                <div>

                    <p class="font-bold">
                        {{ $item['judul'] }}
                    </p>

                    <p class="
                    text-sm
                    text-slate-500
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
            text-slate-500
            py-10
            ">

                Belum ada aktivitas terbaru.

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