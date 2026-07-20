@extends('layouts.app')

@section('title','Draft Baru')

@section('content')

<div class="max-w-5xl mx-auto">

<div class="bg-white rounded-3xl shadow-xl p-8">


<h1 class="text-3xl font-black mb-6">
📝 Buat Draft Surat
</h1>



<form action="{{ route('surat.store') }}" method="POST">

@csrf


<div class="mb-5">

<label class="font-bold">
Perihal Surat
</label>

<input 
type="text"
name="perihal"
class="w-full border rounded-xl p-3 mt-2"
required>

</div>




<div class="mb-5">

<label class="font-bold">
Ringkasan
</label>


<textarea
name="ringkasan"
class="w-full border rounded-xl p-3 mt-2"
rows="3"></textarea>


</div>





<div class="mb-5">

<label class="font-bold">
Isi Surat
</label>


<textarea
name="isi_surat"
class="w-full border rounded-xl p-3 mt-2"
rows="8"></textarea>


</div>




<button
class="
bg-blue-600
text-white
px-6
py-3
rounded-xl
font-bold
">

Simpan Draft

</button>


</form>



</div>

</div>


@endsection