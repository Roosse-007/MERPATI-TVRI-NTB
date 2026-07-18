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


+ Tambah Template


</button>


</div>








<!-- STATISTIK -->


<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">


<div class="bg-white rounded-xl shadow p-6">

<p class="text-gray-500">
Total Template
</p>

<h2 class="text-4xl font-bold text-blue-700 mt-3">
24
</h2>

</div>




<div class="bg-white rounded-xl shadow p-6">

<p class="text-gray-500">
Template Aktif
</p>

<h2 class="text-4xl font-bold text-green-600 mt-3">
20
</h2>

</div>




<div class="bg-white rounded-xl shadow p-6">

<p class="text-gray-500">
Template Nonaktif
</p>

<h2 class="text-4xl font-bold text-red-600 mt-3">
4
</h2>

</div>


</div>








<!-- FILTER -->


<div class="bg-white rounded-xl shadow p-5 mb-6">


<div class="grid md:grid-cols-3 gap-4">


<input
id="searchTemplate"
type="text"
placeholder="Cari Template..."
class="border rounded-lg px-4 py-2">





<select
id="filterKategori"
class="border rounded-lg px-4 py-2">


<option value="Semua">
Semua Kategori
</option>


<option value="Surat Masuk">
Surat Masuk
</option>


<option value="Surat Keluar">
Surat Keluar
</option>


<option value="Disposisi">
Disposisi
</option>


</select>






<button
onclick="filterTemplate()"
class="bg-blue-700 text-white rounded-lg">


Cari


</button>


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
Kategori
</th>


<th class="text-left">
Tanggal
</th>


<th class="text-left">
Status
</th>


<th>
Aksi
</th>


</tr>


</thead>





<tbody id="templateTable">





<tr class="templateRow border-b">


<td class="p-4">
1
</td>


<td class="namaTemplate">
Template Surat Masuk
</td>


<td class="kategori">
Surat Masuk
</td>


<td>
16 Juli 2026
</td>


<td>

<span class="status bg-green-100 text-green-700 px-3 py-1 rounded-full">

Aktif

</span>

</td>


<td>


<button
onclick="editTemplate(this)"
class="bg-yellow-500 text-white px-3 py-2 rounded">

Edit

</button>




<button
onclick="hapusTemplate(this)"
class="bg-red-600 text-white px-3 py-2 rounded">

Hapus

</button>




<button
onclick="previewTemplate()"
class="bg-blue-600 text-white px-3 py-2 rounded">

Preview

</button>


</td>


</tr>








<tr class="templateRow border-b">


<td class="p-4">
2
</td>


<td class="namaTemplate">
Template Surat Keluar
</td>


<td class="kategori">
Surat Keluar
</td>


<td>
16 Juli 2026
</td>


<td>

<span class="status bg-green-100 text-green-700 px-3 py-1 rounded-full">

Aktif

</span>

</td>


<td>


<button
onclick="editTemplate(this)"
class="bg-yellow-500 text-white px-3 py-2 rounded">

Edit

</button>


<button
onclick="hapusTemplate(this)"
class="bg-red-600 text-white px-3 py-2 rounded">

Hapus

</button>


<button
onclick="previewTemplate()"
class="bg-blue-600 text-white px-3 py-2 rounded">

Preview

</button>


</td>


</tr>









<tr class="templateRow">


<td class="p-4">
3
</td>


<td class="namaTemplate">
Template Disposisi
</td>


<td class="kategori">
Disposisi
</td>


<td>
15 Juli 2026
</td>


<td>


<span class="status bg-red-100 text-red-700 px-3 py-1 rounded-full">

Nonaktif

</span>


</td>


<td>


<button
onclick="editTemplate(this)"
class="bg-yellow-500 text-white px-3 py-2 rounded">

Edit

</button>



<button
onclick="hapusTemplate(this)"
class="bg-red-600 text-white px-3 py-2 rounded">

Hapus

</button>



<button
onclick="previewTemplate()"
class="bg-blue-600 text-white px-3 py-2 rounded">

Preview

</button>


</td>


</tr>



</tbody>


</table>


</div>









<!-- MODAL -->


<div
id="templateModal"
class="hidden fixed inset-0 bg-gradient-to-br from-slate-950 via-blue-900 to-blue-600 items-center justify-center">



<div class="bg-white rounded-2xl p-8 w-96 shadow-2xl">


<h2
id="modalTitle"
class="text-xl font-bold mb-5">

Tambah Template

</h2>




<input
id="nama"
placeholder="Nama Template"
class="border w-full p-3 rounded mb-3">





<select
id="kategori"
class="border w-full p-3 rounded mb-3">


<option>
Surat Masuk
</option>


<option>
Surat Keluar
</option>


<option>
Disposisi
</option>


</select>






<textarea
id="isiTemplate"
placeholder="Isi Template Surat"
class="border w-full p-3 rounded mb-3"></textarea>






<button
onclick="simpanTemplate()"
class="bg-blue-700 text-white px-5 py-2 rounded">


Simpan


</button>




<button
onclick="closeTemplateModal()"
class="bg-gray-300 px-5 py-2 rounded">


Batal


</button>


</div>


</div>









<script>


let editMode=false;

let editRow=null;




function openTemplateModal(){


document.getElementById('templateModal')
.classList.remove('hidden');


document.getElementById('templateModal')
.classList.add('flex');


}





function closeTemplateModal(){


document.getElementById('templateModal')
.classList.add('hidden');


}







function simpanTemplate(){



let nama =
document.getElementById('nama').value;



let kategori =
document.getElementById('kategori').value;



if(editMode){


editRow.querySelector('.namaTemplate')
.innerHTML=nama;


editRow.querySelector('.kategori')
.innerHTML=kategori;



}

else{


document.getElementById('templateTable')
.innerHTML += `


<tr class="templateRow border-b">


<td class="p-4">
Baru
</td>


<td class="namaTemplate">
${nama}
</td>


<td class="kategori">
${kategori}
</td>


<td>
Hari ini
</td>


<td>

<span class="status bg-green-100 text-green-700 px-3 py-1 rounded-full">

Aktif

</span>

</td>



<td>


<button onclick="editTemplate(this)"
class="bg-yellow-500 text-white px-3 py-2 rounded">

Edit

</button>


<button onclick="hapusTemplate(this)"
class="bg-red-600 text-white px-3 py-2 rounded">

Hapus

</button>


</td>



</tr>


`;


}



closeTemplateModal();


}







function editTemplate(btn){


editMode=true;


editRow=
btn.closest('tr');



document.getElementById('modalTitle')
.innerHTML="Edit Template";



document.getElementById('nama').value =
editRow.querySelector('.namaTemplate').innerText;



openTemplateModal();


}







function hapusTemplate(btn){


if(confirm("Hapus template ini?")){


btn.closest('tr').remove();


}


}







function filterTemplate(){



let keyword =
document.getElementById('searchTemplate')
.value.toLowerCase();



let kategori =
document.getElementById('filterKategori')
.value;



document.querySelectorAll('.templateRow')
.forEach(row=>{


let nama =
row.querySelector('.namaTemplate')
.innerText.toLowerCase();



let kategoriData =
row.querySelector('.kategori')
.innerText;



if(

nama.includes(keyword)

&&

(kategori=="Semua" || kategori==kategoriData)

){


row.style.display="table-row";


}

else{


row.style.display="none";


}


});


}






function previewTemplate(){


alert("Preview template surat");


}



</script>


@endsection