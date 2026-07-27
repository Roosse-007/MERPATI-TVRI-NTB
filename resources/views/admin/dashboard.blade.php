@extends('layouts.admin')

@section('title','Dashboard')

@section('content')


<!-- HEADER -->

<div class="mb-8 flex justify-between items-center">


    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Dashboard Admin
        </h1>


        <p class="text-gray-500 mt-2">
            Selamat datang di Sistem E-Surat MERPATI TVRI NTB
        </p>

    </div>



    <div>

        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full">

            {{ date('d M Y') }}

        </span>

    </div>


</div>






<!-- STATISTIC CARD -->

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">


<!-- Total Surat -->

<div class="bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-2xl shadow-lg p-6 hover:scale-105 transition">


<div class="flex items-center gap-5">


<div class="bg-white/20 p-4 rounded-xl text-3xl">

<i class="bi bi-envelope-paper"></i>

</div>


<div>

<p class="text-blue-100">
Total Surat
</p>

<h2 class="text-4xl font-bold">
245
</h2>

<p class="text-sm mt-2">
+12 surat bulan ini
</p>

</div>


</div>


</div>





<!-- Total User -->

<div class="bg-gradient-to-r from-green-500 to-green-400 text-white rounded-2xl shadow-lg p-6 hover:scale-105 transition">


<div class="flex items-center gap-5">


<div class="bg-white/20 p-4 rounded-xl text-3xl">

<i class="bi bi-people-fill"></i>

</div>


<div>

<p class="text-green-100">
Total User
</p>


<h2 class="text-4xl font-bold">
58
</h2>


<p class="text-sm mt-2">
Semua akun aktif
</p>


</div>


</div>


</div>





<!-- Approval -->

<div class="bg-gradient-to-r from-yellow-500 to-orange-400 text-white rounded-2xl shadow-lg p-6 hover:scale-105 transition">


<div class="flex items-center gap-5">


<div class="bg-white/20 p-4 rounded-xl text-3xl">

<i class="bi bi-hourglass-split"></i>

</div>


<div>

<p class="text-yellow-100">
Pending Approval
</p>


<h2 class="text-4xl font-bold">
16
</h2>


<p class="text-sm mt-2">
Menunggu tindakan
</p>


</div>


</div>


</div>





<!-- Arsip -->

<div class="bg-gradient-to-r from-purple-600 to-purple-400 text-white rounded-2xl shadow-lg p-6 hover:scale-105 transition">


<div class="flex items-center gap-5">


<div class="bg-white/20 p-4 rounded-xl text-3xl">

<i class="bi bi-archive-fill"></i>

</div>


<div>

<p class="text-purple-100">
Total Arsip
</p>


<h2 class="text-4xl font-bold">
820
</h2>


<p class="text-sm mt-2">
Dokumen tersimpan
</p>


</div>


</div>


</div>


</div>








<!-- QUICK MENU -->


<div class="mt-8 bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5 text-gray-800">

Menu Cepat

</h2>



<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">


<a href="/admin/users"
class="border border-blue-200 bg-blue-50 rounded-2xl p-6 min-h-[150px] flex items-center gap-5 hover:shadow-lg hover:-translate-y-1 transition">


<div class="text-3xl text-blue-600">

<i class="bi bi-people-fill"></i>

</div>


<div>

<h3 class="font-bold text-lg text-blue-700">
Kelola User
</h3>


<p class="text-sm text-gray-500">
Kelola akun pengguna
</p>


</div>


</a>





<a href="/admin/template-surat"
class="border border border-green-200 bg-green-50 rounded-2xl p-6 min-h-[150px] flex items-center gap-5 hover:shadow-lg hover:-translate-y-1 transition">


<div class="text-3xl text-green-600">

<i class="bi bi-file-earmark-text-fill"></i>

</div>


<div>

<h3 class="font-bold text-lg text-green-700">
Template Surat
</h3>


<p class="text-sm text-gray-500">
Kelola template
</p>


</div>


</a>





<a href="/admin/laporan"
class="border border border-yellow-200 bg-yellow-50 rounded-2xl p-6 min-h-[150px] flex items-center gap-5 hover:shadow-lg hover:-translate-y-1 transition">


<div class="text-3xl text-yellow-600">

<i class="bi bi-bar-chart-fill"></i>

</div>


<div>

<h3 class="font-bold text-lg text-yellow-700">
Laporan
</h3>


<p class="text-sm text-gray-500">
Lihat laporan
</p>


</div>


</a>





<a href="/admin/arsip"
class="border border-blue-200 bg-blue-50 rounded-2xl p-6 min-h-[150px] flex items-center gap-5 hover:shadow-lg hover:-translate-y-1 transition">


<div class="text-3xl text-purple-600">

<i class="bi bi-archive-fill"></i>

</div>


<div>

<h3 class="font-bold text-lg text-purple-700">
Arsip
</h3>


<p class="text-sm text-gray-500">
Kelola arsip surat
</p>


</div>


</a>


</div>


</div>








<!-- CHART + STATUS -->


<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-8">



<div class="xl:col-span-2 bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

Statistik Surat

</h2>


<canvas id="chartSurat"></canvas>


</div>







<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

Status Surat

</h2>



<div class="space-y-5">


<div>

<div class="flex justify-between">

<span>
Disetujui
</span>

<span>
70%
</span>

</div>


<div class="bg-gray-200 rounded-full h-3 mt-2">

<div class="bg-green-500 h-3 rounded-full w-[70%]">

</div>

</div>

</div>





<div>


<div class="flex justify-between">

<span>
Diproses
</span>

<span>
20%
</span>

</div>


<div class="bg-gray-200 rounded-full h-3 mt-2">

<div class="bg-yellow-500 h-3 rounded-full w-[20%]">

</div>

</div>

</div>





<div>


<div class="flex justify-between">

<span>
Ditolak
</span>

<span>
10%
</span>

</div>


<div class="bg-gray-200 rounded-full h-3 mt-2">

<div class="bg-red-500 h-3 rounded-full w-[10%]">

</div>

</div>


</div>


</div>


</div>



</div>









<!-- AKTIVITAS -->


<div class="bg-white rounded-2xl shadow mt-8 p-6">


<h2 class="text-xl font-bold mb-5">

Aktivitas Terbaru

</h2>



<div class="space-y-5">



<div class="border-l-4 border-blue-600 pl-4">

<p class="font-semibold">

Surat masuk baru diterima

</p>

<small class="text-gray-400">

5 menit lalu

</small>

</div>





<div class="border-l-4 border-green-600 pl-4">

<p class="font-semibold">

Surat berhasil disetujui

</p>

<small class="text-gray-400">

20 menit lalu

</small>

</div>





<div class="border-l-4 border-yellow-500 pl-4">

<p class="font-semibold">

Menunggu approval kepala bagian

</p>

<small class="text-gray-400">

1 jam lalu

</small>

</div>




</div>


</div>









<!-- TABLE -->


<div class="bg-white rounded-2xl shadow mt-8 overflow-hidden">


<div class="p-6 border-b">


<h2 class="text-xl font-bold">

Surat Terbaru

</h2>


</div>



<div class="overflow-x-auto">


<table class="w-full">


<thead class="bg-blue-700 text-white">


<tr>


<th class="p-4 text-left">
No
</th>


<th>
Nomor Surat
</th>


<th>
Perihal
</th>


<th>
Status
</th>


<th>
Tanggal
</th>


</tr>


</thead>




<tbody>


<tr class="border-b">


<td class="p-4">
1
</td>


<td>
001/TVRI/VII/2026
</td>


<td>
Undangan Rapat
</td>


<td>

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Disetujui

</span>


</td>


<td>
16 Juli 2026
</td>


</tr>





<tr class="border-b">


<td class="p-4">
2
</td>


<td>
002/TVRI/VII/2026
</td>


<td>
Surat Tugas
</td>


<td>

<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

Diproses

</span>


</td>


<td>
16 Juli 2026
</td>


</tr>



</tbody>


</table>


</div>


</div>








<script>


document.addEventListener('DOMContentLoaded',()=>{


const ctx=document.getElementById('chartSurat');


new Chart(ctx,{

type:'line',


data:{


labels:[
'Jan',
'Feb',
'Mar',
'Apr',
'Mei',
'Jun',
'Jul'
],


datasets:[{

label:'Jumlah Surat',


data:[
20,
35,
25,
50,
40,
60,
75
],


borderWidth:3


}]


},


options:{


responsive:true


}



});



});


</script>



@endsection