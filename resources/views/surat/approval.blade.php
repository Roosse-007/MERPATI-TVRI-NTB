@extends('layouts.app')

@section('title','Approval Surat')


@section('content')


<div class="max-w-7xl mx-auto">



{{-- HEADER --}}

<div class="mb-8">

<h1 class="
text-4xl
font-black
text-slate-800
">

<i class="fa-solid fa-circle-check text-green-600"></i>

Approval Surat

</h1>


<p class="text-slate-500 mt-2">

Kelola proses persetujuan surat MERPATI TVRI NTB

</p>


</div>








{{-- STATISTIK --}}

<div class="
grid
md:grid-cols-4
gap-6
mb-8
">


<div class="
bg-white
rounded-3xl
shadow-xl
p-6
">

<p class="text-slate-500">
Total Surat
</p>


<h2 class="text-3xl font-black">

{{ $totalSurat }}

</h2>

</div>





<div class="
bg-yellow-50
rounded-3xl
shadow-xl
p-6
">

<p class="text-yellow-700">

Menunggu

</p>


<h2 class="
text-3xl
font-black
text-yellow-700
">

{{ $menunggu }}

</h2>

</div>





<div class="
bg-green-50
rounded-3xl
shadow-xl
p-6
">


<p class="text-green-700">

Disetujui

</p>


<h2 class="
text-3xl
font-black
text-green-700
">

{{ $disetujui }}

</h2>


</div>





<div class="
bg-red-50
rounded-3xl
shadow-xl
p-6
">


<p class="text-red-700">

Ditolak

</p>


<h2 class="
text-3xl
font-black
text-red-700
">

{{ $ditolak }}

</h2>


</div>



</div>









<div class="space-y-6">



@forelse($surat as $item)



<div class="
bg-white
rounded-3xl
shadow-xl
border
border-slate-200
p-8
">





{{-- HEADER SURAT --}}


<div class="
flex
justify-between
items-start
gap-5
">



<div>


<h2 class="
text-xl
font-black
text-slate-800
">

{{ $item->perihal }}

</h2>



<p class="text-slate-500 mt-2">

Nomor Surat :

<span class="font-bold">

{{ $item->nomor_surat }}

</span>


</p>




<p class="text-sm text-slate-500 mt-3">

Pengirim :

<span class="font-bold">

{{ $item->pengirim->name ?? '-' }}

</span>

</p>



</div>







{{-- STATUS --}}


@php

$status = $item->status;

@endphp



<span class="
px-5
py-2
rounded-full
font-bold
text-sm


@if(
str_contains($status,'KPP')
)

bg-yellow-100
text-yellow-700


@elseif(
str_contains($status,'KTU')
)

bg-blue-100
text-blue-700


@elseif(
str_contains($status,'Kepala')
)

bg-purple-100
text-purple-700


@elseif(
$status == 'Disetujui'
)

bg-green-100
text-green-700


@else

bg-red-100
text-red-700


@endif

">


@if(str_contains($status,'KPP'))

<i class="fa-solid fa-clock"></i>


@elseif(str_contains($status,'KTU'))

<i class="fa-solid fa-pen"></i>


@elseif(str_contains($status,'Kepala'))

<i class="fa-solid fa-user-check"></i>


@elseif($status == 'Disetujui')

<i class="fa-solid fa-check"></i>


@else

<i class="fa-solid fa-xmark"></i>


@endif


{{ $status }}


</span>




</div>







<hr class="my-6">








{{-- AKSI --}}


<div class="
flex
flex-wrap
gap-4
">





<a

href="{{ route('surat.detail',$item->id) }}"

class="
px-6
py-3
rounded-xl
bg-slate-100
font-bold
hover:bg-slate-200
transition
"

>

<i class="fa-solid fa-eye"></i>

Detail

</a>









{{-- KPP --}}


@if(
$item->status == 'Menunggu Verifikasi KPP'
||
$item->status == 'Menunggu Approval KPP'
)



<form method="POST"

action="{{ route('approval.kpp.approve',$item->id) }}">

@csrf


<button class="
px-6
py-3
rounded-xl
bg-green-600
text-white
font-bold
hover:bg-green-700
">

<i class="fa-solid fa-check"></i>

Setujui KPP

</button>


</form>





<form method="POST"

action="{{ route('approval.kpp.reject',$item->id) }}">

@csrf


<button class="
px-6
py-3
rounded-xl
bg-red-600
text-white
font-bold
">

<i class="fa-solid fa-xmark"></i>

Tolak

</button>


</form>


@endif







{{-- KTU --}}



@if(
$item->status == 'Menunggu Paraf KTU'
||
$item->status == 'Menunggu Approval KTU'
)



<form method="POST"

action="{{ route('approval.ktu.approve',$item->id) }}">

@csrf


<button class="
px-6
py-3
rounded-xl
bg-blue-600
text-white
font-bold
">

<i class="fa-solid fa-pen"></i>

Paraf KTU

</button>


</form>




<form method="POST"

action="{{ route('approval.ktu.reject',$item->id) }}">

@csrf


<button class="
px-6
py-3
rounded-xl
bg-red-600
text-white
font-bold
">

Tolak

</button>


</form>


@endif







{{-- KEPALA STASIUN --}}



@if(
$item->status == 'Menunggu Persetujuan Kepala Stasiun'
||
$item->status == 'Menunggu Approval Kepala Stasiun'
)



<form method="POST"

action="{{ route('approval.kepala.approve',$item->id) }}">

@csrf


<button class="
px-6
py-3
rounded-xl
bg-purple-600
text-white
font-bold
">

<i class="fa-solid fa-signature"></i>

Setujui Kepala

</button>


</form>





<form method="POST"

action="{{ route('approval.kepala.reject',$item->id) }}">

@csrf


<button class="
px-6
py-3
rounded-xl
bg-red-600
text-white
font-bold
">

Tolak

</button>


</form>


@endif




</div>










{{-- RIWAYAT APPROVAL --}}



@if($item->approvals->count())


<div class="
mt-6
bg-slate-50
rounded-2xl
p-5
">


<h3 class="
font-black
text-slate-700
mb-4
">

<i class="fa-solid fa-clock-rotate-left"></i>

Riwayat Approval

</h3>





@foreach($item->approvals as $approval)


<div class="
flex
justify-between
border-b
py-3
last:border-0
">


<div>

<p class="font-bold">

{{ $approval->approver->name ?? '-' }}

</p>


<p class="text-xs text-slate-500">

{{ $approval->approved_at }}

</p>


</div>




<span class="
font-bold

@if($approval->status=='Disetujui')

text-green-600

@elseif($approval->status=='Ditolak')

text-red-600

@else

text-yellow-600

@endif

">

{{ $approval->status }}

</span>



</div>



@endforeach



</div>


@endif







</div>





@empty



<div class="
bg-white
rounded-3xl
shadow
p-10
text-center
">


<i class="
fa-solid
fa-inbox
text-5xl
text-slate-300
"></i>


<p class="
mt-4
font-bold
text-slate-500
">

Tidak ada surat menunggu approval.

</p>


</div>



@endforelse




</div>


</div>


@endsection