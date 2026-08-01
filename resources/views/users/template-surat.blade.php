@extends('layouts.app')

@section('title','Template Surat')


@section('content')



<div class="flex justify-between items-center mb-8">


<div>

<div class="flex items-center gap-3">


<i data-lucide="files"
class="
w-10
h-10
text-blue-800
">
</i>



<h1 class="
text-3xl
font-bold
text-gray-800
">
    Template Surat
</h1>


</div>




</div>





</div>









<!-- STATISTIK -->


<div class="
grid
grid-cols-1
md:grid-cols-3
gap-6
mb-8
">


{{-- TOTAL TEMPLATE --}}

<div class="
relative
overflow-hidden
rounded-3xl
p-6
text-white
shadow-xl
bg-gradient-to-br
from-blue-700
to-cyan-500
hover:-translate-y-1
hover:shadow-2xl
transition-all
duration-300
">


<div class="
absolute
-right-10
-top-10
w-32
h-32
bg-white/10
rounded-full
">
</div>


<div class="flex items-center justify-between">


<div>

<p class="text-white/80 font-medium">
Total Template
</p>


<h2 class="text-5xl font-black mt-3">

{{ $totalTemplate }}

</h2>


<p class="text-sm text-white/80 mt-4">
Jumlah seluruh template
</p>


</div>



<div class="
w-16
h-16
rounded-2xl
bg-white/20
backdrop-blur
flex
items-center
justify-center
">


<i data-lucide="files"
class="w-8 h-8">
</i>


</div>


</div>


</div>





{{-- TEMPLATE AKTIF --}}

<div class="
relative
overflow-hidden
rounded-3xl
p-6
text-white
shadow-xl
bg-gradient-to-br
from-emerald-600
to-green-400
hover:-translate-y-1
hover:shadow-2xl
transition-all
duration-300
">


<div class="
absolute
-right-10
-top-10
w-32
h-32
bg-white/10
rounded-full
">
</div>


<div class="flex items-center justify-between">


<div>

<p class="text-white/80 font-medium">
Template Aktif
</p>


<h2 class="text-5xl font-black mt-3">

{{ $templateAktif }}

</h2>


<p class="text-sm text-white/80 mt-4">
Template yang digunakan
</p>


</div>



<div class="
w-16
h-16
rounded-2xl
bg-white/20
backdrop-blur
flex
items-center
justify-center
">


<i data-lucide="badge-check"
class="w-8 h-8">
</i>


</div>


</div>


</div>







{{-- TEMPLATE NONAKTIF --}}

<div class="
relative
overflow-hidden
rounded-3xl
p-6
text-white
shadow-xl
bg-gradient-to-br
from-orange-500
to-amber-400
hover:-translate-y-1
hover:shadow-2xl
transition-all
duration-300
">


<div class="
absolute
-right-10
-top-10
w-32
h-32
bg-white/10
rounded-full
">
</div>


<div class="flex items-center justify-between">


<div>

<p class="text-white/80 font-medium">
Template Nonaktif
</p>


<h2 class="text-5xl font-black mt-3">

{{ $templateNonaktif }}

</h2>


<p class="text-sm text-white/80 mt-4">
Template tidak digunakan
</p>


</div>



<div class="
w-16
h-16
rounded-2xl
bg-white/20
backdrop-blur
flex
items-center
justify-center
">


<i data-lucide="file-x"
class="w-8 h-8">
</i>


</div>


</div>


</div>


</div>









{{-- TABLE TEMPLATE SURAT --}}

<div class="
bg-white
rounded-3xl
shadow-xl
p-8
">


{{-- HEADER TABLE --}}

<div class="mb-6">

<h2 class="
text-2xl
font-black
text-slate-800
flex
items-center
gap-3
">

<i data-lucide="file-text"
class="w-7 h-7 text-blue-700">
</i>


Daftar Template Surat


</h2>

</div>







<div class="
overflow-x-auto
rounded-2xl
border
border-slate-200
">


<table class="w-full">



<thead>


<tr class="
bg-gradient-to-r
from-blue-900
to-blue-700
text-white
">


<th class="
px-6
py-4
text-left
">
No
</th>



<th class="
px-6
py-4
text-left
">
Dokumen
</th>



<th class="
px-6
py-4
text-left
">
Deskripsi
</th>



<th class="
px-6
py-4
text-left
">
Tanggal
</th>



<th class="
px-6
py-4
text-left
">
Status
</th>



<th class="
px-6
py-4
text-center
">
Aksi
</th>


</tr>


</thead>






<tbody>


@forelse($templates as $key=>$template)


<tr class="
border-b
hover:bg-blue-50
transition
">



<td class="
px-6
py-5
font-semibold
text-slate-700
">

{{ $key+1 }}

</td>






<td class="
px-6
py-5
">


<div class="
flex
items-center
gap-3
">


<div class="
w-10
h-10
rounded-xl
bg-blue-100
flex
items-center
justify-center
">


<i data-lucide="file-text"
class="
w-5
h-5
text-blue-700
">
</i>


</div>



<div>


<p class="
font-bold
text-slate-800
">

{{ $template->nama_template }}

</p>


</div>


</div>


</td>








<td class="
px-6
py-5
text-slate-600
">


{{ $template->keterangan ?? '-' }}


</td>








<td class="
px-6
py-5
text-slate-600
">


{{ $template->created_at->format('d M Y') }}


</td>








<td class="
px-6
py-5
">


@if($template->is_active)


<span class="
inline-flex
items-center
gap-2
bg-green-100
text-green-700
px-4
py-2
rounded-full
font-bold
text-sm
">


<i data-lucide="circle-check"
class="w-4 h-4">
</i>


Aktif


</span>



@else


<span class="
inline-flex
items-center
gap-2
bg-red-100
text-red-700
px-4
py-2
rounded-full
font-bold
text-sm
">


<i data-lucide="circle-x"
class="w-4 h-4">
</i>


Nonaktif


</span>


@endif


</td>









<td class="
px-6
py-5
">


<div class="
flex
justify-center
">


@if($template->file_template)


<a
href="{{ asset('storage/'.$template->file_template) }}"
target="_blank"

class="
w-10
h-10
rounded-xl
bg-blue-600
hover:bg-blue-700
text-white
flex
items-center
justify-center
transition
shadow-lg
"
title="Lihat Template"
>


<i data-lucide="eye"
class="w-5 h-5">
</i>


</a>


@else


<button

class="
w-10
h-10
rounded-xl
bg-slate-300
text-white
flex
items-center
justify-center
"

title="File belum tersedia"
>


<i data-lucide="eye-off"
class="w-5 h-5">
</i>


</button>


@endif


</div>


</td>







</tr>



@empty



<tr>

<td colspan="6"
class="
text-center
py-10
text-slate-400
">


<i data-lucide="folder-open"
class="
w-12
h-12
mx-auto
mb-3
">
</i>


Belum ada template surat


</td>


</tr>



@endforelse



</tbody>



</table>


</div>



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