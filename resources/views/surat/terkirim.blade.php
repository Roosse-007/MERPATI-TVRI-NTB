@extends('layouts.app')

@section('title','Surat Terkirim')

@section('content')


<h1 class="text-4xl font-black">
Surat Terkirim 📤
</h1>

<p class="text-slate-500 mt-2">
Riwayat surat yang sudah dikirim
</p>



<div class="
mt-8
grid
md:grid-cols-3
gap-6
">


@foreach([
['judul'=>'Surat Undangan','status'=>'Diterima'],
['judul'=>'Permohonan Data','status'=>'Diproses'],
['judul'=>'Laporan Bulanan','status'=>'Selesai']
] as $item)


<div class="
bg-white
rounded-[30px]
p-7
shadow-lg
hover:-translate-y-2
transition
">


<div class="
w-14 h-14
rounded-2xl
bg-blue-100
flex items-center justify-center
text-3xl
">

📨

</div>


<h3 class="
font-black
text-xl
mt-5
">

{{$item['judul']}}

</h3>


<span class="
inline-block
mt-4
bg-green-100
text-green-600
px-4 py-2
rounded-xl
font-bold
">

{{$item['status']}}

</span>


</div>


@endforeach


</div>


@endsection