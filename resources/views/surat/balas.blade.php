@extends('layouts.app')


@section('content')


<div class="
max-w-4xl
mx-auto
bg-white
rounded-3xl
shadow-xl
p-10
">


<h1 class="
text-3xl
font-black
text-slate-800
mb-8
">

Balas Surat

</h1>




<div class="
bg-blue-50
rounded-xl
p-5
mb-8
">


<p class="text-sm text-slate-500">

Surat yang dibalas:

</p>


<p class="font-bold">

{{ $surat->nomor_surat }}

</p>


<p>

{{ $surat->perihal }}

</p>


</div>







<form

method="POST"

action="{{ route('surat.balas.store',$surat->id) }}"

>


@csrf


<label class="font-bold">

Tujuan Surat

</label>


<select

name="tujuan_id"

class="
w-full
border
rounded-xl
p-3
mb-5
"

>


@foreach(\App\Models\User::all() as $user)

<option value="{{ $user->id }}">

{{ $user->name }}

</option>


@endforeach


</select>


<label class="font-bold">

Perihal

</label>


<input

name="perihal"

value="Balasan {{ $surat->perihal }}"

class="
w-full
border
rounded-xl
p-3
mb-5
"

>






<label class="font-bold">

Ringkasan

</label>


<textarea

name="ringkasan"

class="
w-full
border
rounded-xl
p-3
mb-5
"></textarea>






<label class="font-bold">

Isi Surat

</label>


<textarea

name="isi_surat"

rows="8"

class="
w-full
border
rounded-xl
p-3
mb-5
"></textarea>







<button

class="
w-full
bg-blue-600
text-white
py-3
rounded-xl
font-bold
"

>

Simpan Balasan


</button>



</form>


</div>


@endsection