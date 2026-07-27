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







<!-- =========================
STATISTIK REAL DATABASE
========================= -->


<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">



<div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-xl shadow p-6">

<p>
Surat Masuk
</p>


<h2 class="text-4xl font-bold mt-2">

{{ $suratMasuk }}

</h2>


</div>







<div class="bg-gradient-to-r from-green-600 to-green-400 text-white rounded-xl shadow p-6">


<p>
Surat Keluar
</p>


<h2 class="text-4xl font-bold mt-2">

{{ $suratKeluar }}


</h2>


</div>







<div class="bg-gradient-to-r from-yellow-500 to-yellow-400 text-white rounded-xl shadow p-6">


<p>
Approval
</p>


<h2 class="text-4xl font-bold mt-2">

{{ $approval}}
</h2>


</div>







<div class="bg-gradient-to-r from-purple-600 to-purple-400 text-white rounded-xl shadow p-6">


<p>
Arsip
</p>


<h2 class="text-4xl font-bold mt-2">

{{ $arsip }}

</h2>


</div>




</div>









<!-- =========================
FILTER
========================= -->


<div class="bg-white rounded-xl shadow p-6 mb-8">


<h2 class="text-xl font-bold mb-5">

Filter Laporan

</h2>



<form method="GET"
action="{{ route('admin.laporan') }}">



<div class="grid md:grid-cols-5 gap-4">





<input

type="date"

name="dari"

value="{{ request('dari') }}"

class="border rounded-lg px-4 py-2">







<input

type="date"

name="sampai"

value="{{ request('sampai') }}"

class="border rounded-lg px-4 py-2">








<select

name="jenis"

class="border rounded-lg px-4 py-2">



<option value="">

Semua Jenis

</option>



@foreach($jenisSurat as $jenis)


<option

value="{{ $jenis->id }}"

@if(request('jenis')==$jenis->id)
selected
@endif

>

{{ $jenis->nama_jenis }}

</option>


@endforeach



</select>








<select

name="status"

class="border rounded-lg px-4 py-2">


<option value="">

Semua Status

</option>


<option value="Disetujui"
@if(request('status')=='Disetujui')
selected
@endif
>

Disetujui

</option>



<option value="Diproses"
@if(request('status')=='Diproses')
selected
@endif
>

Diproses

</option>




<option value="Ditolak"
@if(request('status')=='Ditolak')
selected
@endif
>

Ditolak

</option>



</select>







<button

class="bg-blue-700 hover:bg-blue-800 text-white rounded-lg">

Tampilkan

</button>




</div>



</form>



</div>








<!-- =========================
TABLE REAL DATABASE
========================= -->


<div class="bg-white rounded-xl shadow overflow-hidden">


<table class="w-full">


<thead class="bg-blue-800 text-white">


<tr>


<th class="p-4 text-left">
No
</th>


<th class="p-4 text-left">
Nomor Surat
</th>


<th class="p-4 text-left">
Jenis
</th>


<th class="p-4 text-left">
Perihal
</th>


<th class="p-4 text-left">
Tanggal
</th>


<th class="p-4 text-left">
Status
</th>


</tr>


</thead>



<tbody>


@forelse($laporan as $index=>$item)


<tr class="border-b hover:bg-gray-50">



<td class="p-4">

{{ $laporan->firstItem()+$index }}

</td>





<td class="p-4 font-medium">

{{ $item->nomor_surat ?? '-' }}

</td>






<td class="p-4">


{{ $item->jenisSurat->nama_jenis ?? '-' }}


</td>





<td class="p-4">

{{ $item->perihal }}

</td>





<td class="p-4">


{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}


</td>





<td class="p-4">


@if($item->status == 'Disetujui')


<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Disetujui

</span>



@elseif($item->status == 'Ditolak')



<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

Ditolak

</span>




@else


<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

{{ $item->status }}

</span>


@endif



</td>



</tr>



@empty


<tr>


<td colspan="6"
class="text-center py-6 text-gray-500">


Belum ada data laporan surat


</td>


</tr>



@endforelse



</tbody>


</table>



</div>



<div class="mt-6">

{{ $laporan->links() }}

</div><!-- =========================
ACTION
========================= -->


<div class="mt-6 flex justify-between items-center">


<p class="text-gray-500">

Menampilkan data laporan surat

</p>




<a href="{{ route('admin.laporan') }}"

class="border px-5 py-2 rounded-lg hover:bg-gray-100">


Reset Filter


</a>



</div>









<!-- =========================
SCRIPT EXPORT
========================= -->


<script>


function exportExcel(){


let table =
document.querySelector('table');



let rows =
table.querySelectorAll('tr');



let csv = [];



rows.forEach(row=>{


let cols =
row.querySelectorAll('th,td');


let data=[];


cols.forEach(col=>{


data.push(
'"'+col.innerText.trim()+'"'
);


});


csv.push(data.join(','));


});




let blob =
new Blob(
[csv.join('\n')],
{
type:'text/csv'
}
);




let url =
window.URL.createObjectURL(blob);



let a =
document.createElement('a');



a.href=url;



a.download =
'laporan-surat.csv';



a.click();



window.URL.revokeObjectURL(url);



}







function exportPDF(){


window.print();



}



</script>





@endsection