@extends('layouts.admin')

@section('title', 'Nomor Surat')

@section('content')


<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Nomor Surat
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola format dan penomoran surat MERPATI TVRI NTB.
        </p>

    </div>


    <button
    onclick="openNomorModal()"
    class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-lg shadow transition hover:-translate-y-1">

        + Tambah Nomor Surat

    </button>


</div>





<!-- Card Statistik -->

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">


<div class="bg-white rounded-xl shadow p-6">

<p class="text-gray-500">
Total Format
</p>

<h2 class="text-4xl font-bold text-blue-700 mt-3">

{{ $totalFormat }}

</h2>

</div>





<div class="bg-white rounded-xl shadow p-6">

<p class="text-gray-500">
Tahun Aktif
</p>

<h2 class="text-4xl font-bold text-green-600 mt-3">

{{ $tahunAktif ?? '-' }}

</h2>

</div>






<div class="bg-white rounded-xl shadow p-6">

<p class="text-gray-500">
Nomor Terakhir
</p>


<h2 class="text-4xl font-bold text-yellow-500 mt-3">

{{ str_pad($nomorTerakhir ?? 0,5,'0',STR_PAD_LEFT) }}

</h2>


</div>






<div class="bg-white rounded-xl shadow p-6">

<p class="text-gray-500">
Digunakan Hari Ini
</p>


<h2 class="text-4xl font-bold text-red-500 mt-3">

{{ $digunakanHariIni }}

</h2>


</div>



</div>








<!-- Filter -->

<div class="bg-white rounded-xl shadow p-5 mb-6">


<form method="GET"
action="{{ route('admin.nomor') }}">


<div class="grid grid-cols-1 md:grid-cols-4 gap-4">



<input

type="text"

name="search"

value="{{ request('search') }}"

placeholder="Cari Format..."

class="border rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-blue-700">





<select name="tahun"
class="border rounded-lg px-4 py-2">


<option value="">
Semua Tahun
</option>


@foreach($tahunList as $tahun)


<option value="{{ $tahun }}"

@if(request('tahun')==$tahun)
selected
@endif

>

{{ $tahun }}

</option>


@endforeach


</select>





<select name="status"

class="border rounded-lg px-4 py-2">


<option value="">
Semua Status
</option>


<option value="Aktif"
@if(request('status')=='Aktif')
selected
@endif
>
Aktif
</option>



<option value="Nonaktif"
@if(request('status')=='Nonaktif')
selected
@endif
>
Nonaktif
</option>



</select>





<button

class="bg-blue-700 hover:bg-blue-800 text-white rounded-lg">

Cari

</button>



</div>


</form>


</div>







<!-- Table -->

<div class="bg-white rounded-xl shadow overflow-hidden">


<table class="min-w-full">


<thead class="bg-blue-800 text-white">


<tr>


<th class="px-6 py-4 text-left">
No
</th>


<th class="px-6 py-4 text-left">
Format Nomor
</th>


<th class="px-6 py-4 text-left">
Nomor Terakhir
</th>


<th class="px-6 py-4 text-left">
Tahun
</th>


<th class="px-6 py-4 text-left">
Status
</th>


<th class="px-6 py-4 text-center">
Aksi
</th>


</tr>


</thead>


<tbody>


@forelse($nomorSurat as $index=>$item)


<tr class="border-b hover:bg-gray-50">


<td class="px-6 py-4">

{{ $nomorSurat->firstItem()+$index }}

</td>



<td class="px-6 py-4 font-medium">

{{ $item->kode_nomor }}

</td>




<td class="px-6 py-4">

{{ str_pad($item->nomor_terakhir,5,'0',STR_PAD_LEFT) }}

</td>




<td class="px-6 py-4">

{{ $item->tahun }}

</td>




<td class="px-6 py-4">


@if($item->status == 'Aktif')


<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

Aktif

</span>


@else


<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">

Nonaktif

</span>


@endif


</td>




<td class="px-6 py-4 text-center">



<button

data-id="{{ $item->id }}"

data-kode="{{ $item->kode_nomor }}"

data-nomor="{{ $item->nomor_terakhir }}"

data-tahun="{{ $item->tahun }}"

data-status="{{ $item->status }}"

onclick="editNomor(this)"

class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded">

Edit

</button>




<form

action="{{ route('admin.nomor.destroy',$item->id) }}"

method="POST"

class="inline">


@csrf

@method('DELETE')


<button

type="button"

onclick="hapusNomorSurat(this)"

data-id="{{ $item->id }}"

class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded ml-2">

Hapus

</button>


</form>



</td>


</tr>


@empty


<tr>


<td colspan="6"

class="text-center py-6 text-gray-500">


Belum ada data nomor surat


</td>


</tr>


@endforelse


</tbody>


</table>


</div>


<div class="mt-6">

{{ $nomorSurat->links() }}

</div><!-- ========================= -->
<!-- MODAL TAMBAH NOMOR SURAT -->
<!-- ========================= -->


<div id="nomorModal"

class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">


<div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-8">


<div class="flex justify-between items-center mb-6">


<h2 class="text-2xl font-bold text-gray-800">

Tambah Nomor Surat

</h2>



<button

onclick="closeNomorModal()"

class="text-gray-500 text-2xl">

×

</button>


</div>





<form

action="{{ route('admin.nomor.store') }}"

method="POST">


@csrf



<div class="space-y-4">



<div>


<label class="font-semibold">

Jenis Surat

</label>


<select

name="jenis_surat_id"

class="w-full border rounded-lg px-4 py-2 mt-2"

required>


<option value="">

-- Pilih Jenis Surat --

</option>


@foreach(\App\Models\JenisSurat::all() as $jenis)


<option value="{{ $jenis->id }}">

{{ $jenis->nama_jenis }}

</option>


@endforeach


</select>


</div>







<div>



<label class="font-semibold">

Kode Nomor

</label>


<input

type="text"

name="kode_nomor"

placeholder="Contoh: 001/TVRI/NTB"

class="w-full border rounded-lg px-4 py-2 mt-2"

required>


</div>






<div>


<label class="font-semibold">

Tahun

</label>


<input

type="number"

name="tahun"

value="{{ date('Y') }}"

class="w-full border rounded-lg px-4 py-2 mt-2"

required>


</div>



</div>





<div class="flex justify-end gap-3 mt-8">


<button

type="button"

onclick="closeNomorModal()"

class="px-5 py-2 rounded-lg bg-gray-200">


Batal


</button>





<button

class="px-5 py-2 rounded-lg bg-blue-700 text-white">


Simpan


</button>



</div>



</form>



</div>


</div>







<!-- ========================= -->
<!-- MODAL EDIT -->
<!-- ========================= -->


<div id="editModal"

class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">


<div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-8">


<div class="flex justify-between items-center mb-6">


<h2 class="text-2xl font-bold text-gray-800">

Edit Nomor Surat

</h2>



<button

onclick="closeEditModal()"

class="text-gray-500 text-2xl">

×

</button>


</div>





<form

id="editForm"

method="POST">


@csrf

@method('PUT')




<div class="space-y-4">



<!-- FORMAT NOMOR -->

<div>


<label class="font-semibold">

Format Nomor

</label>


<input

id="editKode"

name="kode_nomor"

type="text"

class="w-full border rounded-lg px-4 py-2 mt-2"

required>


</div>






<!-- NOMOR TERAKHIR -->

<div>


<label class="font-semibold">

Nomor Terakhir

</label>


<input

id="editNomor"

name="nomor_terakhir"

type="text"

class="w-full border rounded-lg px-4 py-2 mt-2"

required>


</div>






<!-- TAHUN -->

<div>


<label class="font-semibold">

Tahun

</label>


<input

id="editTahun"

name="tahun"

type="number"

class="w-full border rounded-lg px-4 py-2 mt-2"

required>


</div>






<!-- STATUS -->

<div>


<label class="font-semibold">

Status

</label>


<select

id="editStatus"

name="status"

class="w-full border rounded-lg px-4 py-2 mt-2">


<option value="Aktif">

Aktif

</option>


<option value="Nonaktif">

Nonaktif

</option>


</select>


</div>



</div>






<div class="flex justify-end gap-3 mt-8">


<button

type="button"

onclick="closeEditModal()"

class="px-5 py-2 bg-gray-200 rounded-lg">

Batal

</button>




<button

type="submit"

class="px-5 py-2 bg-yellow-500 text-white rounded-lg">

Update

</button>


</div>



</form>


</div>


</div>








<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>


// buka modal tambah

function openNomorModal(){

document
.getElementById('nomorModal')
.classList
.remove('hidden');

}




function closeNomorModal(){

document
.getElementById('nomorModal')
.classList
.add('hidden');

}







// EDIT DATA REAL

function editNomor(button){


let id = button.dataset.id;


let kode = button.dataset.kode;


let nomor = button.dataset.nomor;


let tahun = button.dataset.tahun;


let status = button.dataset.status;



document
.getElementById('editKode')
.value = kode;



document
.getElementById('editNomor')
.value = String(nomor).padStart(5,'0');



document
.getElementById('editTahun')
.value = tahun;



document
.getElementById('editStatus')
.value = status;



document
.getElementById('editForm')
.action =
"/admin/nomor-surat/"+id;



document
.getElementById('editModal')
.classList
.remove('hidden');


}

function hapusNomorSurat(button){


let id = button.dataset.id;



Swal.fire({

title:'Hapus Nomor Surat?',

text:'Data yang dihapus tidak dapat dikembalikan!',

icon:'warning',


showCancelButton:true,


confirmButtonColor:'#dc2626',


cancelButtonColor:'#6b7280',


confirmButtonText:'Ya, Hapus',


cancelButtonText:'Batal'


}).then((result)=>{


if(result.isConfirmed){



let form = document.getElementById('formHapus');



form.action =
"/admin/nomor-surat/"+id;



form.submit();



}



});


}

function closeEditModal(){


document
.getElementById('editModal')
.classList
.add('hidden');


}



</script>


<form 
id="formHapus"
method="POST"
style="display:none">

@csrf

@method('DELETE')

</form>


@endsection