@extends('layouts.app')

@section('title','Arsip Surat')

@section('content')


<h1 class="text-4xl font-black">
Arsip Surat 🗄️
</h1>


<p class="text-slate-500 mt-2">
Dokumen surat yang tersimpan
</p>




<div class="
mt-8
bg-white
rounded-[32px]
shadow-xl
p-8
">


<table class="w-full">


<thead>

<tr class="text-left text-slate-500">

<th class="p-4">
Nomor
</th>

<th>
Perihal
</th>

<th>
Tanggal
</th>

<th>
Aksi
</th>

</tr>

</thead>


<tbody>


@foreach([
['001','Undangan Rapat'],
['002','Laporan Tahunan'],
['003','Permohonan Data']
] as $item)


<tr class="
border-t
hover:bg-slate-50
">


<td class="p-4 font-bold">
{{$item[0]}}
</td>


<td>
{{$item[1]}}
</td>


<td>
16 Juli 2026
</td>


<td>

<button class="
bg-blue-600
text-white
px-4 py-2
rounded-xl
">

Lihat

</button>

</td>


</tr>


@endforeach


</tbody>


</table>


</div>



@endsection