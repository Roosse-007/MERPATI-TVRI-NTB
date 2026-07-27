@extends('layouts.app')


@section('content')


<div class="
max-w-xl
mx-auto
mt-10
bg-white
rounded-3xl
shadow-xl
border
border-slate-200
p-8
">



<h1 class="
text-2xl
font-black
text-green-700
flex
items-center
gap-3
">

<i class="fa-solid fa-circle-check"></i>

Dokumen Resmi

</h1>




<hr class="my-6">






<div class="space-y-5">



<div>

<p class="text-slate-400 text-sm">

Nomor Verifikasi

</p>


<p class="font-black text-slate-800">

{{ $data->nomor_verifikasi }}

</p>

</div>







<div>

<p class="text-slate-400 text-sm">

Metode Pengesahan

</p>


<p class="font-bold">

{{ $data->metode }}

</p>


</div>








<div>

<p class="text-slate-400 text-sm">

Disahkan Oleh

</p>


<p class="font-bold">

{{ $data->user->name ?? '-' }}

</p>


</div>








<div>

<p class="text-slate-400 text-sm">

Tanggal Pengesahan

</p>


<p class="font-bold">

{{ $data->tanggal_pengesahan?->format('d M Y H:i') }}

</p>


</div>




</div>









@if($data->qr_code)


<hr class="my-6">



<div class="text-center">


<h3 class="
font-black
text-lg
mb-4
">

QR Code Verifikasi

</h3>




<img

src="{{ asset('storage/'.$data->qr_code) }}"

class="
mx-auto
w-48
h-48
border
rounded-xl
p-2
"


>


<p class="
mt-4
text-sm
text-slate-500
">

Scan QR Code untuk memverifikasi dokumen

</p>


</div>



@endif






</div>



@endsection