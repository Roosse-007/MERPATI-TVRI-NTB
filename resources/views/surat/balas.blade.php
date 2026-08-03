@extends('layouts.app')

@section('content')

<div class="
bg-white
rounded-3xl
shadow-xl
border
border-slate-200
overflow-hidden
">


{{-- HEADER --}}

<div class="
bg-gradient-to-r
from-blue-600
to-cyan-500
px-10
py-8
text-white
">


<div class="
flex
justify-between
items-center
">


<div>


<h1 class="
text-3xl
font-black
flex
items-center
gap-3
">

<i class="fa-solid fa-reply"></i>

Balas Surat

</h1>


<p class="
mt-2
text-blue-100
">

Buat surat balasan dari surat yang diterima

</p>


</div>


<a href="{{ route('surat.detail',$surat->id) }}"

class="
w-12
h-12
rounded-full
bg-white/20
hover:bg-white/30
transition
font-bold
flex
items-center
justify-center
text-xl
"

title="Tutup"
>


<i class="fa-solid fa-xmark"></i>


</a>
</div>


</div>






<div class="
p-10
">



{{-- ERROR --}}

@if ($errors->any())

<div class="
bg-red-50
border
border-red-200
text-red-700
px-6
py-4
rounded-2xl
mb-8
">


<p class="font-bold mb-2">

Terjadi Kesalahan:

</p>


<ul class="list-disc list-inside text-sm">

@foreach ($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>


</div>

@endif






<form 
method="POST" 
action="{{ route('surat.balas.store', $surat->id) }}" 
enctype="multipart/form-data"
class="space-y-7"
>

@csrf





{{-- TUJUAN --}}

<div>


<label class="
font-bold
text-slate-700
flex
items-center
gap-2
">


<i class="
fa-solid
fa-user-check
text-blue-600
"></i>


Tujuan Surat


</label>



<input 
type="hidden" 
name="tujuan_id" 
value="{{ $surat->pengirim_id }}"
>




<div class="
mt-3
bg-slate-50
border
border-slate-200
rounded-2xl
p-5
flex
justify-between
items-center
">


<div class="flex items-center gap-3">


<div class="
w-10
h-10
rounded-full
bg-blue-100
text-blue-600
flex
items-center
justify-center
">


<i class="fa-solid fa-user"></i>


</div>


<div>


<p class="font-bold text-slate-800">

{{ $surat->pengirim->name ?? 'Pengirim Asli' }}

</p>


<p class="text-xs text-slate-500">

Penerima balasan surat

</p>


</div>


</div>





<span class="
text-xs
bg-blue-100
text-blue-700
px-3
py-1
rounded-full
font-bold
">

Otomatis

</span>



</div>


</div>







{{-- PERIHAL --}}


<div>


<label class="
font-bold
text-slate-700
flex
items-center
gap-2
">


<i class="
fa-solid
fa-heading
text-blue-600
"></i>


Perihal


</label>



<input 

name="perihal"

value="Balasan {{ $surat->parent_surat_id 
    ? $surat->suratInduk->perihal 
    : $surat->perihal }}"

class="
mt-3
w-full
border
border-slate-300
rounded-2xl
p-4
focus:ring-2
focus:ring-blue-500
focus:border-blue-500
transition
"

required

>



</div>








{{-- ISI BALASAN --}}


<div>


<label class="
font-bold
text-slate-700
flex
items-center
gap-2
">


<i class="
fa-solid
fa-file-lines
text-blue-600
"></i>


Isi Balasan


</label>




<textarea

name="catatan"

rows="8"

class="
mt-3
w-full
rounded-2xl
border
border-slate-300
p-5
resize-none
focus:ring-2
focus:ring-blue-500
focus:border-blue-500
transition
"

placeholder="Tulis isi balasan surat..."

required

></textarea>



</div>









{{-- BUTTON --}}


<div class="
flex
justify-end
gap-4
pt-6
border-t
">


<a href="{{ route('surat.detail',$surat->id) }}"

class="
px-7
py-3
rounded-xl
bg-slate-200
text-slate-700
font-bold
hover:bg-slate-300
transition
flex
items-center
gap-2
">


<i class="fa-solid fa-xmark"></i>


Batal


</a>





<button 

type="submit"

class="
px-7
py-3
rounded-xl
bg-blue-600
text-white
font-bold
hover:bg-blue-700
transition
flex
items-center
gap-2
">


<i class="fa-solid fa-paper-plane"></i>


Kirim Balasan


</button>



</div>





</form>


</div>


</div>


@endsection