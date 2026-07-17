@extends('layouts.app')

@section('title','Draft Surat')

@section('content')

<div>

<h1 class="text-4xl font-black text-slate-800">
Draft Surat 📝
</h1>

<p class="text-slate-500 mt-2">
Surat yang masih dalam proses penyusunan
</p>


<div class="mt-8 bg-white rounded-[32px] shadow-xl p-8">


<div class="flex justify-between items-center mb-6">

<h2 class="text-2xl font-black">
Daftar Draft
</h2>

<button class="
bg-gradient-to-r
from-blue-600
to-cyan-400
text-white
px-6 py-3
rounded-2xl
font-bold
">
+ Draft Baru
</button>

</div>



@foreach([
['judul'=>'Undangan Rapat Internal','tanggal'=>'16 Juli 2026'],
['judul'=>'Laporan Kegiatan Bulanan','tanggal'=>'15 Juli 2026'],
['judul'=>'Surat Pengantar Dokumen','tanggal'=>'14 Juli 2026']
] as $item)


<div class="
flex justify-between items-center
bg-slate-50
rounded-2xl
p-5
mb-4
hover:bg-blue-50
transition
">


<div>

<h3 class="font-bold text-lg">
{{$item['judul']}}
</h3>

<p class="text-slate-400">
{{$item['tanggal']}}
</p>

</div>


<div class="flex gap-3">

<button class="
bg-blue-600
text-white
px-5 py-2
rounded-xl
">
Edit
</button>


<button class="
bg-red-100
text-red-600
px-5 py-2
rounded-xl
">
Hapus
</button>


</div>


</div>


@endforeach


</div>

</div>


@endsection