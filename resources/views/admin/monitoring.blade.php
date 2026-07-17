@extends('layouts.admin')

@section('title','Monitoring Surat')

@section('content')


<!-- HEADER -->

<div class="flex justify-between items-center mb-8">


<div>

<h1 class="text-3xl font-bold text-gray-800">
Monitoring Surat
</h1>


<p class="text-gray-500 mt-2">
Pantau perjalanan surat dari dibuat sampai selesai.
</p>


</div>




<button
onclick="refreshData()"
class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-lg shadow">


🔄 Refresh Data


</button>


</div>








<!-- STATISTIK -->


<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">


<div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-xl shadow p-6">

<p>
Total Surat
</p>

<h2 class="text-4xl font-bold mt-3">
245
</h2>

</div>





<div class="bg-gradient-to-r from-yellow-500 to-yellow-400 text-white rounded-xl shadow p-6">

<p>
Diproses
</p>

<h2 class="text-4xl font-bold mt-3">
28
</h2>

</div>





<div class="bg-gradient-to-r from-green-600 to-green-400 text-white rounded-xl shadow p-6">

<p>
Disetujui
</p>

<h2 class="text-4xl font-bold mt-3">
186
</h2>

</div>





<div class="bg-gradient-to-r from-red-600 to-red-400 text-white rounded-xl shadow p-6">

<p>
Ditolak
</p>

<h2 class="text-4xl font-bold mt-3">
31
</h2>

</div>


</div>









<!-- FILTER -->


<div class="bg-white rounded-xl shadow p-6 mb-8">


<div class="grid md:grid-cols-5 gap-4">


<input
id="searchSurat"
type="text"
placeholder="Cari nomor surat..."
class="border rounded-lg px-4 py-2">





<select
id="filterStatus"
class="border rounded-lg px-4 py-2">


<option value="Semua">
Semua Status
</option>


<option value="Draft">
Draft
</option>


<option value="Diproses">
Diproses
</option>


<option value="Disetujui">
Disetujui
</option>


<option value="Ditolak">
Ditolak
</option>


</select>






<select
class="border rounded-lg px-4 py-2">


<option>
Semua Jenis
</option>


<option>
Surat Masuk
</option>


<option>
Surat Keluar
</option>


</select>





<input
type="date"
class="border rounded-lg px-4 py-2">





<button
onclick="filterMonitoring()"
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
Pengirim
</th>


<th class="text-left">
Tanggal
</th>


<th class="text-left">
Status
</th>


<th>
Progress
</th>


<th>
Aksi
</th>


</tr>


</thead>





<tbody id="monitorTable">


<tr class="border-b data-monitor">


<td class="p-4">
1
</td>


<td class="nomor">
001/TVRI/VII/2026
</td>


<td>
Undangan Rapat
</td>


<td>
Bagian Umum
</td>


<td>
16 Juli 2026
</td>


<td class="status">

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Disetujui

</span>

</td>


<td>


<div class="w-32 bg-gray-200 rounded-full h-3">

<div class="bg-green-600 h-3 rounded-full w-full">

</div>

</div>


</td>


<td>


<button
onclick="detailSurat()"
class="bg-blue-600 text-white px-3 py-2 rounded">


Tracking


</button>


</td>


</tr>









<tr class="border-b data-monitor">


<td class="p-4">
2
</td>


<td class="nomor">
002/TVRI/VII/2026
</td>


<td>
Surat Tugas
</td>


<td>
Kepegawaian
</td>


<td>
15 Juli 2026
</td>


<td class="status">


<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

Diproses

</span>


</td>


<td>


<div class="w-32 bg-gray-200 rounded-full h-3">

<div class="bg-yellow-500 h-3 rounded-full w-[60%]">

</div>

</div>


</td>


<td>


<button
onclick="detailSurat()"
class="bg-blue-600 text-white px-3 py-2 rounded">


Tracking


</button>


</td>


</tr>









<tr class="data-monitor">


<td class="p-4">
3
</td>


<td class="nomor">
003/TVRI/VII/2026
</td>


<td>
Nota Dinas
</td>


<td>
Keuangan
</td>


<td>
14 Juli 2026
</td>


<td class="status">


<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

Ditolak

</span>


</td>


<td>


<div class="w-32 bg-gray-200 rounded-full h-3">

<div class="bg-red-600 h-3 rounded-full w-full">

</div>

</div>


</td>


<td>


<button
onclick="detailSurat()"
class="bg-blue-600 text-white px-3 py-2 rounded">


Tracking


</button>


</td>


</tr>


</tbody>


</table>


</div>









<!-- MODAL TRACKING -->


<div
id="trackingModal"
class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">


<div class="bg-white rounded-xl p-8 w-96">


<h2 class="text-xl font-bold mb-6">

Tracking Surat

</h2>





<div class="space-y-5">



<div class="border-l-4 border-green-600 pl-4">

<p class="font-bold">
Surat Dibuat
</p>

<small>
16 Juli 2026
</small>

</div>





<div class="border-l-4 border-green-600 pl-4">

<p class="font-bold">
Dikirim
</p>

<small>
16 Juli 2026
</small>

</div>





<div class="border-l-4 border-yellow-500 pl-4">

<p class="font-bold">
Approval Kepala
</p>

<small>
Menunggu proses
</small>

</div>





<div class="border-l-4 border-gray-400 pl-4">

<p class="font-bold">
Arsip
</p>

<small>
Belum selesai
</small>

</div>


</div>





<button
onclick="closeTracking()"
class="mt-6 bg-gray-300 px-5 py-2 rounded">

Tutup

</button>


</div>


</div>








<script>


function refreshData(){

alert("Data monitoring berhasil diperbarui");

}





function detailSurat(){

document.getElementById('trackingModal')
.classList.remove('hidden');


document.getElementById('trackingModal')
.classList.add('flex');


}





function closeTracking(){

document.getElementById('trackingModal')
.classList.add('hidden');


}





function filterMonitoring(){


let keyword =
document.getElementById('searchSurat')
.value.toLowerCase();


let status =
document.getElementById('filterStatus')
.value;



let rows =
document.querySelectorAll('.data-monitor');



rows.forEach(row=>{


let nomor =
row.querySelector('.nomor')
.innerText.toLowerCase();



let statusData =
row.querySelector('.status')
.innerText.trim();



if(

nomor.includes(keyword)

&&

(status=="Semua" || status==statusData)

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