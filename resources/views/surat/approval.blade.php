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





{{-- HEADER CARD --}}

<div class="
bg-gradient-to-r
from-blue-700
to-cyan-400
rounded-[32px]
p-8
text-white
shadow-xl
">


<p class="text-blue-100">
Surat Aktif
</p>


<h2 class="
text-3xl
font-black
mt-2
">

Surat Permohonan Kerja Sama

</h2>


<div class="
mt-5
flex
gap-4
">


<span class="
bg-white/20
px-4
py-2
rounded-xl
">

📄 001/TVRI/2026

</span>


<span class="
bg-white/20
px-4
py-2
rounded-xl
">

Berjalan

</span>


</div>


</div>







{{-- TIMELINE --}}

<div class="
mt-10
bg-white
rounded-[32px]
shadow-xl
p-10
">


<h2 class="
text-2xl
font-black
mb-10
">

Progress Approval

</h2>



<div class="relative">


{{-- garis --}}

<div class="
absolute
left-6
top-0
bottom-0
w-1
bg-blue-200
">

</div>





@foreach([

[
'title'=>'Surat dibuat',
'name'=>'Admin Staff',
'status'=>'Selesai'
],

[
'title'=>'Pemeriksaan Kepala Bagian',
'name'=>'Budi Santoso',
'status'=>'Disetujui'
],

[
'title'=>'Persetujuan Direktur',
'name'=>'Direktur TVRI NTB',
'status'=>'Menunggu'
]


] as $step)



<div class="
relative
flex
gap-6
mb-10
">


<div class="
relative
z-10
w-12
h-12
rounded-full
bg-gradient-to-br
from-blue-600
to-cyan-400
text-white
flex
items-center
justify-center
font-bold
shadow-lg
">

✓

</div>




<div class="
flex-1
bg-slate-50
rounded-2xl
p-5
">


<div class="
flex
justify-between
">


<div>

<h3 class="
font-black
text-lg
">

{{$step['title']}}

</h3>


<p class="text-slate-500">

{{$step['name']}}

</p>


</div>



<span class="
bg-blue-100
text-blue-600
px-4
py-2
rounded-xl
font-bold
">

{{$step['status']}}

</span>


</div>


</div>



</div>


@endforeach



</div>



</div>



</div>


@endsection