@extends('layouts.admin')

@section('title','Template Surat')


@section('content')



<div class="flex justify-between items-center mb-8">


<div>

<h1 class="text-3xl font-bold text-gray-800">
Template Surat
</h1>


<p class="text-gray-500 mt-2">
Kelola template surat MERPATI TVRI NTB
</p>


</div>




<button
onclick="openTemplateModal()"
class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-lg shadow">


<i class="fa-solid fa-plus"></i>

Tambah Template


</button>


</div>









<!-- STATISTIK -->


<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">



<div class="bg-white rounded-xl shadow p-6">

<p class="text-gray-500">
Total Template
</p>


<h2 class="text-4xl font-bold text-blue-700 mt-3">

{{ $totalTemplate }}

</h2>


</div>






<div class="bg-white rounded-xl shadow p-6">

<p class="text-gray-500">
Template Aktif
</p>


<h2 class="text-4xl font-bold text-green-600 mt-3">

{{ $templateAktif }}

</h2>


</div>








<div class="bg-white rounded-xl shadow p-6">

<p class="text-gray-500">
Template Nonaktif
</p>


<h2 class="text-4xl font-bold text-red-600 mt-3">

{{ $templateNonaktif }}

</h2>


</div>



</div>









<!-- TABLE -->


<div class="bg-white rounded-xl shadow overflow-hidden">


<table class="w-full">


<thead class="bg-blue-800 text-white">


<tr>


<th class="p-4 text-left">
No
</th>


<th class="text-left">
Nama Template
</th>


<th class="text-left">
Keterangan
</th>


<th class="text-left">
Tanggal
</th>


<th class="text-left">
Status
</th>


<th class="text-center">
Aksi
</th>


</tr>


</thead>







<tbody>



@forelse($templates as $key=>$template)



<tr class="border-b hover:bg-gray-50">



<td class="p-4">

{{ $key+1 }}

</td>






<td class="font-semibold">

{{ $template->nama_template }}

</td>






<td>

{{ $template->keterangan ?? '-' }}

</td>






<td>

{{ $template->created_at->format('d M Y') }}

</td>








<td>


@if($template->is_active)



<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Aktif

</span>



@else



<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

Nonaktif

</span>



@endif


</td>









<td>


<div class="flex justify-center gap-2">





<!-- EDIT -->


<a

href="{{ route('template.edit',$template->id) }}"

title="Edit Template"

class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg">


<i class="fa-solid fa-pen"></i>


</a>








<!-- STATUS -->


<form

action="{{ route('template.status',$template->id) }}"

method="POST">


@csrf

@method('PATCH')



<button

title="Ubah Status"

class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-lg">


<i class="fa-solid fa-power-off"></i>


</button>


</form>









<!-- PREVIEW -->


@if($template->file_template)



<a

href="{{ asset('storage/'.$template->file_template) }}"

target="_blank"

title="Preview Template"

class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg">


<i class="fa-solid fa-eye"></i>


</a>



@else


<button

onclick="alert('File template belum tersedia')"

title="Preview Template"

class="bg-blue-300 text-white p-2 rounded-lg">


<i class="fa-solid fa-eye"></i>


</button>



@endif











<!-- DELETE -->


<form

action="{{ route('template.destroy',$template->id) }}"

method="POST"

onsubmit="return confirm('Hapus template ini?')">


@csrf

@method('DELETE')



<button

title="Hapus Template"

class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg">


<i class="fa-solid fa-trash"></i>


</button>


</form>







</div>


</td>





</tr>





@empty


<tr>

<td colspan="6"

class="text-center p-5 text-gray-500">


Belum ada template


</td>


</tr>



@endforelse




</tbody>



</table>


</div>














<!-- MODAL TAMBAH -->


<div

id="templateModal"

class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center">






<div class="bg-white rounded-xl p-8 w-96 shadow-xl">


<h2 class="text-xl font-bold mb-5">

Tambah Template

</h2>







<form

action="{{ route('template.store') }}"

method="POST"

enctype="multipart/form-data">


@csrf







<input

name="nama_template"

placeholder="Nama Template"

class="border w-full p-3 rounded mb-3"

required>








<input

type="file"

name="file_template"

class="border w-full p-3 rounded mb-3"

accept=".pdf,.doc,.docx">







<textarea

name="keterangan"

placeholder="Keterangan Template"

class="border w-full p-3 rounded mb-3"></textarea>







<button

class="bg-blue-700 text-white px-5 py-2 rounded">


Simpan


</button>







<button

type="button"

onclick="closeTemplateModal()"

class="bg-gray-300 px-5 py-2 rounded">


Batal


</button>







</form>


</div>



</div>









<script>


function openTemplateModal(){


document
.getElementById('templateModal')
.classList.remove('hidden');



document
.getElementById('templateModal')
.classList.add('flex');


}





function closeTemplateModal(){


document
.getElementById('templateModal')
.classList.add('hidden');


}



</script>



@endsection