@extends('layouts.app')

@section('title','Grafik Statistik')

@section('content')


<!-- HEADER -->

<div class="flex justify-between items-center mb-8">


    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Grafik & Statistik
        </h1>


        <p class="text-gray-500 mt-2">
            Analisis perkembangan surat MERPATI TVRI NTB
        </p>

    </div>



    <div class="flex gap-3">


        <select 
        id="tahunGrafik"
        class="border rounded-lg px-4 py-2">


            <option value="2026">
                2026
            </option>


            <option value="2025">
                2025
            </option>


            <option value="2024">
                2024
            </option>


        </select>




        <button
        onclick="filterGrafik()"
        class="bg-blue-700 text-white px-5 py-2 rounded-lg hover:bg-blue-800">


            Tampilkan


        </button>


    </div>


</div>





<!-- ALERT -->

<div
id="alertGrafik"
class="hidden mb-6 bg-green-100 text-green-700 px-5 py-3 rounded-lg">


</div>








<!-- CARD STATISTIK -->


<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">



<div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-2xl shadow p-6">


<div class="flex justify-between">


<div>

<p class="text-blue-100">
Surat Masuk
</p>


<h2 class="text-4xl font-bold mt-3">
{{ $suratMasuk }}
</h2>


</div>


<div class="text-5xl">

<i class="bi bi-envelope-arrow-down"></i>

</div>


</div>


<p class="mt-4 text-sm">
+15% bulan ini
</p>


</div>







<div class="bg-gradient-to-r from-green-600 to-green-400 text-white rounded-2xl shadow p-6">


<div class="flex justify-between">


<div>

<p class="text-green-100">
Surat Keluar
</p>


<h2 class="text-4xl font-bold mt-3">
{{ $suratKeluar }}
</h2>


</div>


<div class="text-5xl">

<i class="bi bi-envelope-arrow-up"></i>

</div>


</div>


<p class="mt-4 text-sm">
+8% bulan ini
</p>


</div>







<div class="bg-gradient-to-r from-yellow-500 to-yellow-400 text-white rounded-2xl shadow p-6">


<div class="flex justify-between">


<div>

<p class="text-yellow-100">
Approval
</p>


<h2 class="text-4xl font-bold mt-3">
{{ $approval }}
</h2>


</div>


<div class="text-5xl">

<i class="bi bi-hourglass-split"></i>

</div>


</div>


<p class="mt-4 text-sm">
Menunggu proses
</p>


</div>







<div class="bg-gradient-to-r from-purple-600 to-purple-400 text-white rounded-2xl shadow p-6">


<div class="flex justify-between">


<div>

<p class="text-purple-100">
Arsip
</p>


<h2 class="text-4xl font-bold mt-3">
{{ $arsip }}
</h2>


</div>


<div class="text-5xl">

    <i class="bi bi-archive-fill"></i>

</div>

</div>


<p class="mt-4 text-sm">
Dokumen tersimpan
</p>


</div>



</div>









<!-- CHART -->

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">



<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">
Trend Surat Bulanan
</h2>


<canvas id="trendSurat"></canvas>


</div>







<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">
Perbandingan Surat
</h2>


<canvas id="compareSurat"></canvas>


</div>


</div>







<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">



<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">
Status Surat
</h2>


<canvas id="statusSurat"></canvas>


</div>





<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">
Kategori Surat
</h2>


<canvas id="kategoriSurat"></canvas>


</div>



</div>








<!-- INSIGHT -->

<div class="bg-white rounded-2xl shadow p-6 mt-8">


<h2 class="text-xl font-bold mb-5">
Ringkasan Analisis
</h2>



<div class="grid md:grid-cols-3 gap-5">


<div class="bg-blue-50 p-5 rounded-xl">

<h3 class="font-bold text-blue-700">
Surat Terbanyak
</h3>

<p class="mt-2">
Surat Masuk
</p>

</div>




<div class="bg-green-50 p-5 rounded-xl">

<h3 class="font-bold text-green-700">
Persetujuan
</h3>

<p class="mt-2">
60% Disetujui
</p>

</div>




<div class="bg-yellow-50 p-5 rounded-xl">

<h3 class="font-bold text-yellow-700">
Status Aktif
</h3>

<p class="mt-2">
32 Surat diproses
</p>

</div>


</div>


</div>








<script id="chart-data" type="application/json">
{!! json_encode($chartData ?? []) !!}
</script>

<script>

const chartData = JSON.parse(
    document.getElementById('chart-data').textContent
);



const grafikData = chartData.grafik ?? [];

const compareData = chartData.compare ?? [];

const statusData = chartData.status ?? [];

const kategoriData = chartData.kategori ?? [];


document.addEventListener('DOMContentLoaded', function(){


    // TREND SURAT

    new Chart(
        document.getElementById('trendSurat'),
        {

            type:'line',

            data:{

                labels:[
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'Mei',
                    'Jun',
                    'Jul',
                    'Ags',
                    'Sep',
                    'Okt',
                    'Nov',
                    'Des'
                ],

                datasets:[{

                    label:'Jumlah Surat',

                    data:grafikData,

                    borderWidth:3

                }]

            },


            options:{
                responsive:true
            }

        }

    );




    // PERBANDINGAN SURAT

    new Chart(
        document.getElementById('compareSurat'),
        {

            type:'bar',

            data:{

                labels:[
                    'Surat Masuk',
                    'Surat Keluar'
                ],

                datasets:[{

                    label:'Jumlah Surat',

                    data:compareData,

                    borderWidth:2

                }]

            },


            options:{
                responsive:true
            }

        }

    );




    // STATUS SURAT

    new Chart(
        document.getElementById('statusSurat'),
        {

            type:'doughnut',

            data:{

                labels:[
                'Draft',
                'Diproses',
                'Disetujui',
                'Ditolak'
            ],

                datasets:[{

                    data:statusData

                }]

            },


            options:{
                responsive:true
            }

        }

    );





    // KATEGORI SURAT

    new Chart(
        document.getElementById('kategoriSurat'),
        {

            type:'polarArea',

            data:{

               labels:[
                'Surat Masuk',
                'Surat Keluar',
                'Surat Internal',
                'Nota Dinas',
                'Surat Produksi',
                'Surat Undangan',
                'Surat Tugas'
            ],

                datasets:[{

                    data:kategoriData

                }]

            },


            options:{
                responsive:true
            }

        }

    );



});


</script>


@endsection