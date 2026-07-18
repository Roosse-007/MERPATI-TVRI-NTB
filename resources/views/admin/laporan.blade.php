@extends('layouts.admin')

@section('title','Laporan')

@section('content')


<div class="flex justify-between items-center mb-8">


<div>

<h1 class="text-3xl font-bold text-gray-800">
Laporan Surat
</h1>


<p class="text-gray-500 mt-2">
Rekapitulasi laporan surat MERPATI TVRI NTB
</p>


</div>



<div class="flex gap-3">


<button
onclick="exportExcel()"
class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg shadow">

📊 Export Excel

</button>




<button
onclick="exportPDF()"
class="bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-lg shadow">

📄 Export PDF

</button>


</div>


</div>






<!-- STATISTIK -->


<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">


<div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-xl shadow p-6">

<p>
Surat Masuk
</p>


<h2 class="text-4xl font-bold mt-3">
245
</h2>


</div>




<div class="bg-gradient-to-r from-green-600 to-green-400 text-white rounded-xl shadow p-6">

<p>
Surat Keluar
</p>


<h2 class="text-4xl font-bold mt-3">
186
</h2>


</div>





<div class="bg-gradient-to-r from-yellow-500 to-yellow-400 text-white rounded-xl shadow p-6">

<p>
Approval
</p>


<h2 class="text-4xl font-bold mt-3">
32
</h2>


</div>





<div class="bg-gradient-to-r from-purple-600 to-purple-400 text-white rounded-xl shadow p-6">

<p>
Arsip
</p>


<h2 class="text-4xl font-bold mt-3">
786
</h2>


</div>


</div>









<!-- FILTER -->


<div class="bg-white rounded-xl shadow p-6 mb-8">


<h2 class="text-xl font-bold mb-5">
Filter Laporan
</h2>



<div class="grid md:grid-cols-5 gap-4">



<input
type="date"
id="tanggalMulai"
class="border rounded-lg px-4 py-2">



<input
type="date"
id="tanggalAkhir"
class="border rounded-lg px-4 py-2">





<select
id="jenisSurat"
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


</select>






<select
id="statusSurat"
class="border rounded-lg px-4 py-2">


<option value="Semua">
Semua Status
</option>


<option value="Disetujui">
Disetujui
</option>


<option value="Diproses">
Diproses
</option>


<option value="Ditolak">
Ditolak
</option>


</select>





<button
onclick="filterLaporan()"
class="bg-blue-700 hover:bg-blue-800 text-white rounded-lg">

Tampilkan

</button>



</div>


</div>









<!-- TABLE -->


<div class="bg-white rounded-xl shadow overflow-hidden">


<table class="w-full" id="tableLaporan">


<thead class="bg-blue-800 text-white">


<tr>


<th class="p-4 text-left">
No
</th>


<th class="text-left">
Nomor Surat
</th>


<th class="text-left">
Jenis
</th>


<th class="text-left">
Perihal
</th>


<th class="text-left">
Tanggal
</th>


<th class="text-left">
Status
</th>


</tr>


</thead>




<tbody>



<tr class="border-b data-row">


<td class="p-4">
1
</td>


<td>
001/TVRI/VII/2026
</td>


<td class="jenis">
Surat Masuk
</td>


<td>
Undangan Rapat
</td>


<td>
16 Juli 2026
</td>


<td class="status">

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Disetujui

</span>

</td>


</tr>








<tr class="border-b data-row">


<td class="p-4">
2
</td>


<td>
002/TVRI/VII/2026
</td>


<td class="jenis">
Surat Keluar
</td>


<td>
Surat Tugas
</td>


<td>
15 Juli 2026
</td>


<td class="status">

<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

Diproses

</span>

</td>


</tr>








<tr class="border-b data-row">


<td class="p-4">
3
</td>


<td>
003/TVRI/VII/2026
</td>


<td class="jenis">
Surat Keluar
</td>


<td>
Nota Dinas
</td>


<td>
14 Juli 2026
</td>


<td class="status">

<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

Ditolak

</span>

</td>


</tr>




</tbody>


</table>


</div>









<div class="mt-6 flex justify-between">


<p class="text-gray-500">

Menampilkan data laporan

</p>



<button
onclick="resetFilter()"
class="border px-5 py-2 rounded-lg">


Reset Filter

</button>


</div>









<script>


function filterLaporan(){



let jenis =
document.getElementById('jenisSurat').value;



let status =
document.getElementById('statusSurat').value;



let rows =
document.querySelectorAll('.data-row');




rows.forEach(row=>{


let jenisData =
row.querySelector('.jenis').innerText;


let statusData =
row.querySelector('.status').innerText.trim();



if(

(jenis=="Semua" || jenis==jenisData)

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









function resetFilter(){


document.getElementById('jenisSurat').value="Semua";


document.getElementById('statusSurat').value="Semua";



filterLaporan();


}









function exportExcel(){



let csv = 
"No,Nomor Surat,Jenis,Perihal,Tanggal,Status\n"+
"1,001/TVRI/VII/2026,Surat Masuk,Undangan Rapat,16 Juli 2026,Disetujui\n"+
"2,002/TVRI/VII/2026,Surat Keluar,Surat Tugas,15 Juli 2026,Diproses";



let blob =
new Blob([csv],{type:'text/csv'});


let url =
window.URL.createObjectURL(blob);



let a =
document.createElement('a');


a.href=url;


a.download="laporan-surat.csv";


a.click();



}







function exportPDF(){


window.print();


}



</script>



@endsection