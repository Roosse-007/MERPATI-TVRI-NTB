@extends('layouts.app')

@section('title','Disposisi Surat')


@section('content')


<div class="relative">


<x-flying-dove />



{{-- HEADER --}}

<div class="mb-8">


<h1 class="text-4xl font-black text-slate-800 flex items-center gap-3">

<i class="fa-solid fa-paper-plane text-blue-600"></i>

Disposisi Surat

</h1>


<p class="text-slate-500 mt-2">

Kelola alur penerusan surat antar bagian secara digital

</p>


</div>









{{-- SURAT AKTIF --}}


<div class="
relative
overflow-hidden
bg-gradient-to-r
from-blue-700
via-blue-600
to-cyan-400
rounded-[32px]
p-8
text-white
shadow-xl
">


<div class="
absolute
right-0
top-0
w-80
h-80
bg-white/20
rounded-full
blur-3xl
"></div>



<div class="relative">


<div class="flex justify-between items-start">


<div>


<p class="text-blue-100">
Surat Aktif
</p>


<h2 class="text-3xl font-black mt-3">

{{ $surat->perihal }}

</h2>



<p class="mt-3 text-blue-100">

Nomor :

<span class="font-semibold">

{{ $surat->nomor_surat }}

</span>

</p>



<p class="mt-2 text-blue-100">

Pengirim :

<span class="font-semibold">

{{ $surat->pengirim->name ?? '-' }}

</span>

</p>




<p class="mt-2 text-blue-100">

Tanggal :

<span class="font-semibold">

{{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}

</span>

</p>



</div>




<span class="
bg-white/20
px-5
py-3
rounded-2xl
font-bold
">


{{ $surat->prioritasSurat->nama_prioritas ?? '-' }}


</span>



</div>


</div>


</div>









{{-- FLOW DISPOSISI --}}


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
text-slate-800
flex
items-center
gap-3
">


<i class="fa-solid fa-diagram-project text-blue-600"></i>

Alur Disposisi


</h2>






<div class="
mt-10
grid
md:grid-cols-4
gap-6
">


@forelse($surat->disposisi as $item)



<div class="
bg-slate-50
rounded-[28px]
p-6
text-center
hover:-translate-y-2
transition
">


<div class="text-blue-600 text-4xl">


<i class="fa-solid fa-user"></i>


</div>




<h3 class="mt-4 font-black">


{{ $item->keUser->name ?? '-' }}


</h3>




<p class="text-slate-500 mt-2">


{{ $item->keUser->jabatan->nama_jabatan ?? '-' }}


</p>



</div>



@empty


<p class="text-slate-500">

Belum ada disposisi.

</p>


@endforelse



</div>


</div>









{{-- DETAIL DISPOSISI --}}



<div class="
mt-10
grid
md:grid-cols-2
gap-8
">





{{-- INSTRUKSI --}}


<div class="
bg-white
rounded-[32px]
shadow-xl
p-8
">


<h2 class="
text-2xl
font-black
mb-6
flex
gap-3
items-center
">


<i class="fa-solid fa-message text-blue-600"></i>

Instruksi


</h2>




<div class="
bg-blue-50
rounded-2xl
p-5
">


@if($surat->disposisi->isNotEmpty())


{{ $surat->disposisi->last()->instruksi }}


@else


Belum ada instruksi.


@endif



</div>




</div>









{{-- STATUS --}}


<div class="
bg-white
rounded-[32px]
shadow-xl
p-8
">


<h2 class="
text-2xl
font-black
mb-6
flex
items-center
gap-3
">


<i class="fa-solid fa-list-check text-blue-600"></i>

Status Disposisi


</h2>





<div class="space-y-5">


@forelse($surat->disposisi as $item)


<div class="
flex
justify-between
items-center
bg-slate-50
rounded-2xl
p-5
">


<div>


<p class="font-bold">

{{ $item->keUser->name ?? '-' }}

</p>



<p class="text-sm text-slate-500">

{{ $item->instruksi }}

</p>


@if($item->deadline)

<p class="text-xs text-red-500 mt-2">

Deadline :

{{ $item->deadline->format('d M Y') }}

</p>

@endif


</div>




<span class="
px-4
py-2
rounded-xl
font-bold

@if($item->status == 'Selesai')

bg-green-100 text-green-700

@else

bg-yellow-100 text-yellow-700

@endif

">


{{ $item->status }}


</span>



</div>



@empty


<p class="text-slate-500">

Belum ada disposisi.


</p>


@endforelse


</div>



</div>



</div>









{{-- FORM DISPOSISI --}}


<form

method="POST"

action="{{ route('disposisi.store') }}"

class="
mt-10
bg-white
rounded-[32px]
shadow-xl
p-8
">


@csrf



<input

type="hidden"

name="surat_id"

value="{{ $surat->id }}"

>




<h2 class="
text-2xl
font-black
mb-6
flex
items-center
gap-3
">


<i class="fa-solid fa-paper-plane text-blue-600"></i>

Buat Disposisi Baru


</h2>









<label class="font-bold">

Pilih Penerima

</label>





<div class="
mt-4
grid
md:grid-cols-2
gap-4
">


@foreach($users as $user)


<label class="
flex
items-center
gap-4
border
rounded-2xl
p-4
cursor-pointer
hover:bg-blue-50
">


<input

type="checkbox"

name="ke_user_id[]"

value="{{ $user->id }}"

class="w-5 h-5"

>



<div>


<p class="font-bold">

{{ $user->name }}

</p>


@if($user->jabatan)


<p class="text-sm text-slate-500">

{{ $user->jabatan->nama_jabatan }}

</p>


@endif


</div>



</label>



@endforeach


</div>









<div class="mt-6">


<label class="font-bold">

Instruksi

</label>


<textarea

name="instruksi"

required

rows="4"

placeholder="Masukkan instruksi disposisi"

class="
mt-2
w-full
rounded-2xl
bg-slate-100
px-5
py-4
"

></textarea>


</div>









<div class="mt-6">


<label class="font-bold">

Deadline


</label>


<input

type="date"

name="deadline"

class="
mt-2
w-full
rounded-2xl
bg-slate-100
px-5
py-4
"


>


</div>









<button

type="submit"

class="
mt-6
bg-gradient-to-r
from-blue-600
to-cyan-400
text-white
px-8
py-4
rounded-2xl
font-bold
shadow-lg
hover:scale-105
transition
">


<i class="fa-solid fa-paper-plane"></i>

Kirim Disposisi


</button>




</form>




</div>


@endsection