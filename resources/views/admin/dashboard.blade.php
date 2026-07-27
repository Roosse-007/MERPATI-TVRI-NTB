@extends('layouts.admin')

@section('title','Dashboard Admin')


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



<!-- TOTAL SURAT -->

<div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-2xl shadow-lg p-6">


<div class="flex justify-between">


<div>

<p class="text-blue-100">
Total Surat
</p>


<h2 class="text-4xl font-bold mt-3">

{{ $totalSurat }}

</h2>


</div>


<div class="text-5xl">
📄
</div>


</div>


<p class="mt-4 text-sm">

Total dokumen surat

</p>


</div>






<!-- USER -->

<div class="bg-gradient-to-r from-green-500 to-green-400 text-white rounded-2xl shadow-lg p-6">


<div class="flex justify-between">


<div>

<p class="text-green-100">
Total User
</p>


<h2 class="text-4xl font-bold mt-3">

{{ $totalUser }}

</h2>


</div>


<div class="text-5xl">
👥
</div>


</div>


<p class="mt-4 text-sm">

Akun pengguna sistem

</p>


</div>







<!-- APPROVAL -->


<div class="bg-gradient-to-r from-yellow-500 to-yellow-400 text-white rounded-2xl shadow-lg p-6">


<div class="flex justify-between">


<div>

<p class="text-yellow-100">
Pending Approval
</p>


<h2 class="text-4xl font-bold mt-3">

{{ $pendingApproval }}

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








<!-- ARSIP -->


<div class="bg-gradient-to-r from-purple-600 to-purple-400 text-white rounded-2xl shadow-lg p-6">


<div class="flex justify-between">


<div>

<p class="text-purple-100">
Total Arsip
</p>


<h2 class="text-4xl font-bold mt-3">

{{ $totalArsip }}

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
class="p-5 rounded-xl bg-blue-50 hover:bg-blue-100 text-center">


<div class="text-3xl">
👥
</div>


<p class="mt-2 font-semibold">
Kelola User
</p>


</a>



<a href="/admin/template-surat"
class="p-5 rounded-xl bg-green-50 hover:bg-green-100 text-center">


<div class="text-3xl">
📄
</div>


<p class="mt-2 font-semibold">
Template Surat
</p>


</a>




<a href="/admin/laporan"
class="p-5 rounded-xl bg-yellow-50 hover:bg-yellow-100 text-center">


<div class="text-3xl">
📊
</div>


<p class="mt-2 font-semibold">
Laporan
</p>


</a>




<a href="/surat/arsip"
class="p-5 rounded-xl bg-purple-50 hover:bg-purple-100 text-center">


<div class="text-3xl">
🗂️
</div>


<p class="mt-2 font-semibold">
Arsip
</p>


</a>


</div>


</div>










<!-- CHART -->

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-8">



<div class="xl:col-span-2 bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

Statistik Surat

</h2>


<canvas id="chartSurat"></canvas>


</div>







<!-- STATUS -->

<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

Status Surat

</h2>



<div class="space-y-5">


@foreach($statusSurat as $status)


@php

$total = $totalSurat > 0 
? round(($status->jumlah/$totalSurat)*100)
:0;

@endphp



<div>


<div class="flex justify-between">


<span>

{{ $status->status }}

</span>


<span>

{{ $total }}%

</span>


</div>



<div class="bg-gray-200 rounded-full h-3 mt-2">


<div class="bg-blue-600 h-3 rounded-full"
style="width:{{ $total }}%">
</div>


</div>


</div>



@endforeach



</div>


</div>



</div>









<!-- AKTIVITAS -->


<div class="bg-white rounded-2xl shadow mt-8 p-6">


<h2 class="text-xl font-bold mb-5">

Aktivitas Terbaru

</h2>




<div class="space-y-5">


@foreach($aktivitas as $item)



<div class="border-l-4 border-blue-600 pl-4">


<p class="font-semibold">

Surat :
{{ $item->perihal }}

</p>


<small class="text-gray-400">

{{ $item->created_at->diffForHumans() }}

</small>


</div>



@endforeach



</div>


</div>









<!-- SURAT TERBARU -->


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


@foreach($suratTerbaru as $key=>$surat)



<tr class="border-b">


<td class="p-4">

{{ $key+1 }}

</td>



<td>

{{ $surat->nomor_surat }}

</td>



<td>

{{ $surat->perihal }}

</td>




<td>


<span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">


{{ $surat->status }}


</span>


</td>




<td>

{{ $surat->created_at->format('d M Y') }}

</td>



</tr>



@endforeach



</tbody>



</table>


</div>


</div>









<!-- CHART SCRIPT -->


<script>


document.addEventListener('DOMContentLoaded',()=>{


const ctx=document.getElementById('chartSurat');


new Chart(ctx,{


type:'line',


data:{


labels:@json($statistikSurat->pluck('bulan')),


datasets:[{


label:'Jumlah Surat',


data:@json($statistikSurat->pluck('jumlah')),


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