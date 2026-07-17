@extends('layouts.admin')

@section('title','Arsip Surat')

@section('content')


<!-- HEADER -->

<div class="flex justify-between items-center mb-8">


<div>

<h1 class="text-3xl font-bold text-gray-800">
Arsip Surat
</h1>


<p class="text-gray-500 mt-2">
Kelola dokumen surat yang telah selesai diproses.
</p>


</div>




<button
onclick="openTambahModal()"
class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-lg shadow">

+ Tambah Arsip

</button>


</div>







<!-- STATISTIK -->


<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">



<div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-xl shadow p-6">

<p>
Total Arsip
</p>

<h2 class="text-4xl font-bold mt-3">
786
</h2>

</div>





<div class="bg-gradient-to-r from-green-600 to-green-400 text-white rounded-xl shadow p-6">

<p>
Surat Masuk
</p>

<h2 class="text-4xl font-bold mt-3">
425
</h2>

</div>





<div class="bg-gradient-to-r from-yellow-500 to-yellow-400 text-white rounded-xl shadow p-6">

<p>
Surat Keluar
</p>

<h2 class="text-4xl font-bold mt-3">
301
</h2>

</div>





<div class="bg-gradient-to-r from-purple-600 to-purple-400 text-white rounded-xl shadow p-6">

<p>
Disposisi
</p>

<h2 class="text-4xl font-bold mt-3">
60
</h2>

</div>


</div>









<!-- FILTER -->


<div class="bg-white rounded-xl shadow p-6 mb-8">


<div class="grid md:grid-cols-4 gap-4">


<input
id="searchArsip"
type="text"
placeholder="Cari nomor surat..."
class="border rounded-lg px-4 py-2">





<select
id="jenisArsip"
class="border rounded-lg px-4 py-2">


<option value="Semua">
Semua Jenis
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





<input
type="date"
class="border rounded-lg px-4 py-2">





<button
onclick="filterArsip()"
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
Nomor Surat
</th>


<th class="text-left">
Perihal
</th>


<th class="text-left">
Jenis
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





<tbody id="tableArsip">



<tr class="border-b data-arsip">


<td class="p-4">
1
</td>


<td class="nomor">
001/TVRI/VII/2026
</td>


<td>
Undangan Rapat
</td>


<td class="jenis">
Surat Masuk
</td>


<td>
16 Juli 2026
</td>


<td>

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Diarsipkan

</span>

</td>


<td>


<button
onclick="detailArsip()"
class="bg-blue-600 text-white px-3 py-2 rounded">

Detail

</button>


<button
onclick="editArsip()"
class="bg-yellow-500 text-white px-3 py-2 rounded">

Edit

</button>


<button
onclick="downloadArsip()"
class="bg-green-600 text-white px-3 py-2 rounded">

Download

</button>


</td>


</tr>







<tr class="border-b data-arsip">


<td class="p-4">
2
</td>


<td class="nomor">
002/TVRI/VII/2026
</td>


<td>
Surat Tugas
</td>


<td class="jenis">
Surat Keluar
</td>


<td>
15 Juli 2026
</td>


<td>

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Diarsipkan

</span>

</td>


<td>


<button
onclick="detailArsip()"
class="bg-blue-600 text-white px-3 py-2 rounded">

Detail

</button>


<button
onclick="editArsip()"
class="bg-yellow-500 text-white px-3 py-2 rounded">

Edit

</button>


<button
onclick="downloadArsip()"
class="bg-green-600 text-white px-3 py-2 rounded">

Download

</button>


</td>


</tr>



</tbody>


</table>


</div>









<!-- MODAL -->



<div
id="arsipModal"
class="hidden fixed inset-0 bg-gradient-to-br from-slate-950 via-blue-900 to-blue-600 items-center justify-center">


<div class="bg-white rounded-2xl p-8 w-96 shadow-2xl">


<h2
id="judulModal"
class="text-xl font-bold mb-5">

Tambah Arsip

</h2>



<input
placeholder="Nomor Surat"
class="border w-full p-3 rounded mb-3">



<input
placeholder="Perihal"
class="border w-full p-3 rounded mb-3">



<button
onclick="closeModal()"
class="bg-gray-300 px-5 py-2 rounded">

Tutup

</button>


</div>


</div>









<script>


function openTambahModal(){

document.getElementById('arsipModal')
.classList.remove('hidden');


document.getElementById('arsipModal')
.classList.add('flex');


}






function closeModal(){

document.getElementById('arsipModal')
.classList.add('hidden');


}





function detailArsip(){

alert(
"Detail arsip surat ditampilkan"
);

}




function editArsip(){

document.getElementById('judulModal')
.innerHTML="Edit Arsip";


openTambahModal();


}




function downloadArsip(){

alert(
"Download arsip berhasil"
);


}






function filterArsip(){


let search =
document.getElementById('searchArsip')
.value.toLowerCase();



let jenis =
document.getElementById('jenisArsip')
.value;



let rows =
document.querySelectorAll('.data-arsip');



rows.forEach(row=>{


let nomor =
row.querySelector('.nomor')
.innerText.toLowerCase();



let jenisData =
row.querySelector('.jenis')
.innerText;



if(

nomor.includes(search)

&&

(jenis=="Semua" || jenis==jenisData)

){


row.style.display="table-row";


}

else{


row.style.display="none";


}



});



}



</script>


@endsection