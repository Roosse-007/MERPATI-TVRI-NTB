@extends('layouts.app')


@section('title','Detail Disposisi')


@section('content')


<div class="max-w-5xl mx-auto space-y-8">



{{-- HEADER --}}

<div class="
bg-white
rounded-3xl
shadow-xl
border
p-8
">


<div class="flex justify-between items-start">


<div>


<h1 class="
text-3xl
font-black
text-slate-800
">

Detail Disposisi Surat

</h1>


<p class="
text-slate-500
mt-2
">

Informasi detail disposisi surat

</p>


</div>



<a

href="{{ route('surat.detail',$disposisi->surat_id) }}"

class="
bg-slate-200
px-5
py-3
rounded-xl
font-bold
">

Kembali

</a>



</div>



</div>







{{-- INFORMASI SURAT --}}


<div class="
bg-white
rounded-3xl
shadow-xl
border
p-8
">


<h2 class="
text-xl
font-black
mb-6
">

Informasi Surat

</h2>




<div class="grid md:grid-cols-2 gap-6">


<div>

<p class="text-slate-500">
Nomor Surat
</p>

<p class="font-bold">

{{ $disposisi->surat->nomor_surat }}

</p>

</div>



<div>

<p class="text-slate-500">
Perihal
</p>

<p class="font-bold">

{{ $disposisi->surat->perihal }}

</p>

</div>



</div>


</div>








{{-- DETAIL DISPOSISI --}}


<div class="
bg-white
rounded-3xl
shadow-xl
border
p-8
">


<h2 class="
text-xl
font-black
mb-6
">

Detail Disposisi

</h2>




<div class="space-y-5">



<div>

<p class="text-slate-500">
Dari
</p>


<p class="font-bold">

{{ $disposisi->dariUser->name }}

</p>

</div>





<div>

<p class="text-slate-500">
Kepada
</p>


<p class="font-bold">

{{ $disposisi->keUser->name }}

</p>

</div>






<div>

<p class="text-slate-500">
Instruksi
</p>


<div class="
bg-slate-50
rounded-xl
p-5
mt-2
">

{{ $disposisi->instruksi }}

</div>


</div>






<div>

<p class="text-slate-500">
Deadline
</p>


<p class="font-bold">

{{ $disposisi->deadline 
? $disposisi->deadline->format('d M Y')
: '-'
}}

</p>


</div>






<div>

<p class="text-slate-500">
Status
</p>



@if($disposisi->status=='Selesai')


<span class="
bg-green-100
text-green-700
px-4
py-2
rounded-full
font-bold
">

Selesai

</span>


@else


<span class="
bg-yellow-100
text-yellow-700
px-4
py-2
rounded-full
font-bold
">

{{ $disposisi->status }}

</span>


@endif



</div>




</div>


</div>








{{-- AKSI --}}


<div class="
bg-white
rounded-3xl
shadow-xl
border
p-8
">


<h2 class="
text-xl
font-black
mb-6
">

Tindakan

</h2>



<div class="flex gap-4">



<form method="POST"
action="/surat/disposisi/{{ $disposisi->id }}/read">

@csrf
@method('PUT')


<button

class="
bg-blue-600
text-white
px-6
py-3
rounded-xl
font-bold
">

Tandai Dibaca

</button>


</form>







<form method="POST"
action="/surat/disposisi/{{ $disposisi->id }}/finish">


@csrf

@method('PUT')


<button

class="
bg-green-600
text-white
px-6
py-3
rounded-xl
font-bold
">

Selesaikan

</button>


</form>




</div>


</div>




</div>


@endsection