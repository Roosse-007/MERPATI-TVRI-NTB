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



    <!-- Surat -->

    <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-2xl shadow-lg p-6">


        <div class="flex justify-between">


            <div>

                <p class="text-blue-100">
                    Total Surat
                </p>


                <h2 class="text-4xl font-bold mt-3">
                    245
                </h2>


            </div>


            <div class="text-5xl">

                📄

            </div>


        </div>


        <p class="mt-4 text-sm">

            +12 surat bulan ini

        </p>


    </div>





    <!-- User -->


    <div class="bg-gradient-to-r from-green-500 to-green-400 text-white rounded-2xl shadow-lg p-6">


        <div class="flex justify-between">


            <div>


                <p class="text-green-100">
                    Total User
                </p>


                <h2 class="text-4xl font-bold mt-3">
                    58
                </h2>


            </div>



            <div class="text-5xl">

                👥

            </div>



        </div>


        <p class="mt-4 text-sm">

            Semua akun aktif

        </p>



    </div>






    <!-- Approval -->


    <div class="bg-gradient-to-r from-yellow-500 to-yellow-400 text-white rounded-2xl shadow-lg p-6">


        <div class="flex justify-between">


            <div>

                <p class="text-yellow-100">
                    Pending Approval
                </p>


                <h2 class="text-4xl font-bold mt-3">
                    16
                </h2>


            </div>



            <div class="text-5xl">

                ⏳

            </div>



        </div>


        <p class="mt-4 text-sm">

            Menunggu tindakan

        </p>


    </div>







    <!-- Arsip -->


    <div class="bg-gradient-to-r from-purple-600 to-purple-400 text-white rounded-2xl shadow-lg p-6">


        <div class="flex justify-between">


            <div>


                <p class="text-purple-100">
                    Total Arsip
                </p>


                <h2 class="text-4xl font-bold mt-3">
                    820
                </h2>


            </div>



            <div class="text-5xl">

                🗂️

            </div>



        </div>


        <p class="mt-4 text-sm">

            Dokumen tersimpan

        </p>


    </div>



</div>








<!-- QUICK MENU -->


<div class="mt-8 bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

Menu Cepat

</h2>



<div class="grid grid-cols-2 md:grid-cols-4 gap-5">



<a href="/admin/users"
class="p-5 rounded-xl bg-blue-50 hover:bg-blue-100 transition text-center">


<div class="text-3xl">

👥

</div>


<p class="mt-2 font-semibold">

Kelola User

</p>


</a>





<a href="/admin/template-surat"
class="p-5 rounded-xl bg-green-50 hover:bg-green-100 transition text-center">


<div class="text-3xl">

📄

</div>


<p class="mt-2 font-semibold">

Template Surat

</p>


</a>





<a href="/admin/laporan"
class="p-5 rounded-xl bg-yellow-50 hover:bg-yellow-100 transition text-center">


<div class="text-3xl">

📊

</div>


<p class="mt-2 font-semibold">

Laporan

</p>


</a>





<a href="/admin/arsip"
class="p-5 rounded-xl bg-purple-50 hover:bg-purple-100 transition text-center">


<div class="text-3xl">

🗂️

</div>


<p class="mt-2 font-semibold">

Arsip

</p>


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