@extends('layouts.app')

@section('title','Kotak Masuk')

@section('content')


{{-- HEADER --}}
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">


<div>

<h1 class="text-4xl font-black text-slate-800">
    Kotak Masuk
</h1>

<p class="text-slate-500 mt-2">
    Daftar surat masuk yang diterima oleh unit kerja
</p>

</div>



<button class="
bg-gradient-to-r
from-blue-600
to-cyan-400
text-white
px-7
py-3
rounded-2xl
font-bold
shadow-lg
hover:scale-105
transition
">

+ Surat Baru

</button>


</div>



{{-- STAT CARD --}}

<div class="
grid
grid-cols-1
md:grid-cols-3
gap-6
mt-8
">


<div class="
bg-white
rounded-[28px]
p-6
shadow-lg
border-l-4
border-blue-500
">

<p class="text-slate-500">
Total Surat
</p>

<h2 class="text-4xl font-black mt-2">
240
</h2>

</div>



<div class="
bg-white
rounded-[28px]
p-6
shadow-lg
border-l-4
border-green-500
">

<p class="text-slate-500">
Sudah Dibaca
</p>

<h2 class="text-4xl font-black mt-2">
180
</h2>

</div>




<div class="
bg-white
rounded-[28px]
p-6
shadow-lg
border-l-4
border-orange-500
">

<p class="text-slate-500">
Belum Dibaca
</p>

<h2 class="text-4xl font-black mt-2">
60
</h2>

</div>


</div>





{{-- SEARCH FILTER --}}

<div class="
mt-10
bg-white
rounded-[28px]
p-6
shadow-lg
">


<div class="
flex
flex-col
md:flex-row
gap-4
">


<input

type="text"

placeholder="Cari nomor surat atau pengirim..."

class="
flex-1
bg-slate-100
rounded-2xl
px-5
py-4
outline-none
focus:ring-2
focus:ring-blue-500
"


>


<select

class="
bg-slate-100
rounded-2xl
px-5
py-4
outline-none
">

<option>
Semua Status
</option>

<option>
Baru
</option>

<option>
Dibaca
</option>

<option>
Diproses
</option>


</select>


</div>


</div>






{{-- LIST SURAT --}}

<div class="
mt-8
space-y-5
">


@foreach([
[
'pengirim'=>'Dinas Kominfo NTB',
'judul'=>'Undangan Rapat Koordinasi',
'tanggal'=>'16 Juli 2026',
'status'=>'Baru'
],

[
'pengirim'=>'Pemerintah Provinsi NTB',
'judul'=>'Permohonan Data Pegawai',
'tanggal'=>'15 Juli 2026',
'status'=>'Diproses'
],

[
'pengirim'=>'Bagian Umum TVRI',
'judul'=>'Laporan Kegiatan Bulanan',
'tanggal'=>'14 Juli 2026',
'status'=>'Selesai'
]

] as $surat)



<div class="
bg-white
rounded-[28px]
p-6
shadow-lg
hover:-translate-y-1
transition
">


<div class="
flex
items-center
justify-between
">


<div class="flex gap-5 items-center">


<div class="
w-14
h-14
rounded-2xl
bg-blue-100
flex
items-center
justify-center
text-2xl
">

📩

</div>


<div>


<h3 class="
font-black
text-xl
text-slate-800
">

{{$surat['judul']}}

</h3>


<p class="
text-slate-500
mt-1
">

{{$surat['pengirim']}}

</p>


<p class="
text-sm
text-slate-400
mt-1
">

{{$surat['tanggal']}}

</p>


</div>


</div>





<span class="
px-4
py-2
rounded-xl
font-bold
text-sm

@if($surat['status']=='Baru')

bg-blue-100 text-blue-600

@elseif($surat['status']=='Diproses')

bg-orange-100 text-orange-600

@else

bg-green-100 text-green-600

@endif

">


{{$surat['status']}}


</span>



</div>




<div class="
mt-5
flex
gap-3
">


<button class="
px-5
py-2
rounded-xl
bg-blue-600
text-white
font-bold
">

Lihat

</button>


<button class="
px-5
py-2
rounded-xl
bg-slate-100
font-bold
">

Download

</button>


</div>


</div>


@endforeach


</div>



@endsection