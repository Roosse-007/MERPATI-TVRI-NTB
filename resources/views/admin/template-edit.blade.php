@extends('layouts.admin')

@section('title','Edit Template Surat')


@section('content')



<div class="mb-8 flex justify-between items-center">


<div>

<h1 class="text-3xl font-bold text-gray-800">
Edit Template Surat
</h1>


<p class="text-gray-500 mt-2">
Perbarui template surat MERPATI TVRI NTB
</p>


</div>





<a href="{{ route('admin.template') }}"
class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-3 rounded-lg">


<i class="fa-solid fa-arrow-left"></i>

Kembali


</a>



</div>









<div class="bg-white rounded-xl shadow p-8">





@if(session('success'))

<div class="bg-green-100 text-green-700 p-4 rounded-lg mb-5">

{{ session('success') }}

</div>

@endif






@if($errors->any())

<div class="bg-red-100 text-red-700 p-4 rounded-lg mb-5">


<ul>

@foreach($errors->all() as $error)

<li>
{{ $error }}
</li>

@endforeach

</ul>


</div>

@endif







<form

action="{{ route('template.update',$template->id) }}"

method="POST"

enctype="multipart/form-data">


@csrf

@method('PUT')








<!-- NAMA TEMPLATE -->


<div class="mb-6">


<label class="block font-semibold mb-2">

Nama Template

</label>



<input

type="text"

name="nama_template"

value="{{ old('nama_template',$template->nama_template) }}"

class="border rounded-lg w-full p-3 focus:ring focus:ring-blue-200"

required>



</div>









<!-- FILE TEMPLATE -->


<div class="mb-6">


<label class="block font-semibold mb-2">

File Template

</label>





@if($template->file_template)



<div class="bg-blue-50 p-4 rounded-lg mb-3 flex justify-between items-center">



<div>


<p class="text-sm text-gray-600">

File saat ini:

</p>


<p class="font-semibold">

{{ basename($template->file_template) }}

</p>



</div>







<a

href="{{ asset('storage/'.$template->file_template) }}"

target="_blank"

class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">


<i class="fa-solid fa-eye"></i>

Lihat


</a>



</div>



@endif







<input

type="file"

name="file_template"

accept=".pdf,.doc,.docx"

class="border rounded-lg w-full p-3">





<p class="text-sm text-gray-500 mt-2">

Kosongkan jika tidak ingin mengganti file

</p>



</div>












<!-- KETERANGAN -->


<div class="mb-6">


<label class="block font-semibold mb-2">

Keterangan

</label>




<textarea

name="keterangan"

rows="5"

class="border rounded-lg w-full p-3">{{ old('keterangan',$template->keterangan) }}</textarea>



</div>









<!-- STATUS -->


<div class="mb-6">


<label class="block font-semibold mb-2">

Status Template

</label>




<select

name="is_active"

class="border rounded-lg w-full p-3">



<option value="1"

{{ $template->is_active == 1 ? 'selected':'' }}>

Aktif

</option>





<option value="0"

{{ $template->is_active == 0 ? 'selected':'' }}>

Nonaktif

</option>




</select>



</div>









<div class="flex gap-3">



<button

class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-3 rounded-lg">


<i class="fa-solid fa-save"></i>

Simpan Perubahan


</button>







<a

href="{{ route('admin.template') }}"

class="bg-gray-300 hover:bg-gray-400 px-6 py-3 rounded-lg">


Batal


</a>





</div>







</form>



</div>





@endsection