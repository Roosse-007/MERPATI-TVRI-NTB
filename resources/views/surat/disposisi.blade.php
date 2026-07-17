@extends('layouts.app')

@section('title','Disposisi Surat')

@section('content')


<div class="relative">

<x-flying-dove />


{{-- HEADER --}}

<div class="mb-8">


<h1 class="
text-4xl
font-black
text-slate-800
">

Disposisi Surat 📌

</h1>


<p class="
text-slate-500
mt-2
">

Kelola alur penerusan surat antar bagian secara digital

</p>


</div>





{{-- SURAT AKTIF --}}

<div class="
relative
overflow-hidden
bg-gradient-to-r
from-blue-700
via-blue-600
to-cyan-400
rounded-[32px]
p-8
text-white
shadow-xl
">


<div class="
absolute
right-0
top-0
w-80
h-80
bg-white/20
rounded-full
blur-3xl
"></div>



<div class="relative">


<div class="
flex
justify-between
items-start
">


<div>


<p class="text-blue-100">

Surat Aktif

</p>


<h2 class="
text-3xl
font-black
mt-3
">

Permohonan Kerja Sama TVRI NTB

</h2>


<p class="
mt-3
text-blue-100
">

Nomor:
001/TVRI/NTB/VII/2026

</p>


</div>



<span class="
bg-white/20
px-5
py-3
rounded-2xl
font-bold
">

🔥 Prioritas Tinggi

</span>


</div>



</div>


</div>








{{-- FLOW DISPOSISI --}}

<div class="
mt-10
bg-white
rounded-[32px]
shadow-xl
p-10
">


<h2 class="
text-2xl
font-black
text-slate-800
">

Alur Disposisi

</h2>




<div class="
mt-10
grid
md:grid-cols-4
gap-6
">


@foreach([

[
'icon'=>'📨',
'title'=>'Surat Masuk',
'name'=>'Admin'
],

[
'icon'=>'👨‍💼',
'title'=>'Kepala Bagian',
'name'=>'Budi Santoso'
],

[
'icon'=>'👨‍💻',
'title'=>'Staff Pelaksana',
'name'=>'Ahmad Rizki'
],

[
'icon'=>'✅',
'title'=>'Selesai',
'name'=>'Arsip'
]

] as $flow)


<div class="
relative
bg-slate-50
rounded-[28px]
p-6
text-center
hover:-translate-y-2
transition
">


<div class="
text-5xl
">

{{$flow['icon']}}

</div>



<h3 class="
mt-4
font-black
">

{{$flow['title']}}

</h3>



<p class="
text-slate-500
mt-2
">

{{$flow['name']}}

</p>


</div>


@endforeach


</div>



</div>








{{-- DETAIL DISPOSISI --}}

<div class="
mt-10
grid
md:grid-cols-2
gap-8
">





{{-- CATATAN --}}

<div class="
bg-white
rounded-[32px]
shadow-xl
p-8
">


<h2 class="
text-2xl
font-black
mb-6
">

Instruksi

</h2>



<div class="
bg-blue-50
rounded-2xl
p-5
text-slate-700
">


"Lakukan pemeriksaan dokumen dan siapkan laporan tindak lanjut."


</div>



<div class="mt-6">


<p class="
text-sm
text-slate-400
">

Dibuat oleh

</p>


<p class="font-bold">

Admin TVRI NTB

</p>


</div>


</div>






{{-- STATUS --}}

<div class="
bg-white
rounded-[32px]
shadow-xl
p-8
">


<h2 class="
text-2xl
font-black
mb-6
">

Status Disposisi

</h2>



<div class="space-y-5">



<div class="
flex
justify-between
items-center
bg-green-50
rounded-2xl
p-5
">


<div>

<p class="font-bold">

Kepala Bagian

</p>


<p class="text-sm text-slate-500">

Sudah diproses

</p>


</div>



<span class="
bg-green-100
text-green-600
px-4
py-2
rounded-xl
font-bold
">

Selesai

</span>


</div>





<div class="
flex
justify-between
items-center
bg-orange-50
rounded-2xl
p-5
">


<div>

<p class="font-bold">

Staff Pelaksana

</p>


<p class="text-sm text-slate-500">

Menunggu tindakan

</p>


</div>



<span class="
bg-orange-100
text-orange-600
px-4
py-2
rounded-xl
font-bold
">

Pending

</span>


</div>



</div>


</div>



</div>








{{-- BUAT DISPOSISI --}}


<div class="
mt-10
bg-white
rounded-[32px]
shadow-xl
p-8
">


<h2 class="
text-2xl
font-black
mb-6
">

Buat Disposisi Baru

</h2>



<div class="
grid
md:grid-cols-2
gap-6
">



<div>


<label class="font-bold">

Tujuan Bagian

</label>


<select class="
mt-2
w-full
rounded-2xl
bg-slate-100
px-5
py-4
">

<option>
Pilih bagian
</option>

<option>
Keuangan
</option>

<option>
Produksi
</option>

<option>
Administrasi
</option>

</select>


</div>




<div>


<label class="font-bold">

Batas Waktu

</label>


<input

type="date"

class="
mt-2
w-full
rounded-2xl
bg-slate-100
px-5
py-4
"


>


</div>


</div>




<textarea

rows="4"

placeholder="Tambahkan instruksi disposisi..."

class="
mt-6
w-full
rounded-2xl
bg-slate-100
px-5
py-4
"

></textarea>



<button class="
mt-6
bg-gradient-to-r
from-blue-600
to-cyan-400
text-white
px-8
py-4
rounded-2xl
font-bold
shadow-lg
hover:scale-105
transition
">

Kirim Disposisi

</button>



</div>



</div>


@endsection