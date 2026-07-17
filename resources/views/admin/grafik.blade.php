@extends('layouts.admin')

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
245
</h2>


</div>


<div class="text-5xl">
📥
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
186
</h2>


</div>


<div class="text-5xl">
📤
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
32
</h2>


</div>


<div class="text-5xl">
⏳
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
786
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









<script>


let chartTrend;



document.addEventListener('DOMContentLoaded',function(){



chartTrend = new Chart(
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
'Jul'
],


datasets:[{

label:'Jumlah Surat',


data:[
30,
45,
40,
60,
55,
75,
90
],


borderWidth:3,

fill:true


}]


},


options:{


responsive:true


}


});






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

label:'Jumlah',

data:[
245,
186
]


}]


},


options:{
responsive:true
}


});







new Chart(
document.getElementById('statusSurat'),
{


type:'doughnut',


data:{


labels:[
'Disetujui',
'Diproses',
'Ditolak'
],


datasets:[{


data:[
60,
25,
15
]


}]


}



});







new Chart(
document.getElementById('kategoriSurat'),
{


type:'polarArea',


data:{


labels:[
'Dinas',
'Undangan',
'Nota',
'Laporan'
],


datasets:[{


data:[
40,
30,
20,
10
]


}]


}



});



});









function filterGrafik(){



let tahun =
document.getElementById('tahunGrafik').value;



let alert =
document.getElementById('alertGrafik');



alert.innerHTML =
"Menampilkan statistik surat tahun " + tahun;



alert.classList.remove('hidden');





let data;



if(tahun=="2026"){


data=[
30,
45,
40,
60,
55,
75,
90
];


}

else if(tahun=="2025"){


data=[
20,
35,
30,
45,
50,
60,
70
];


}

else{


data=[
15,
25,
30,
40,
45,
55,
65
];


}




chartTrend.data.datasets[0].data=data;


chartTrend.update();





setTimeout(function(){


alert.classList.add('hidden');


},3000);



}



</script>


@endsection