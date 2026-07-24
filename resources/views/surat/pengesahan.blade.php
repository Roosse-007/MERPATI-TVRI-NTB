@extends('layouts.app')


@section('title','Pengesahan Surat')


@section('content')


<div class="max-w-3xl mx-auto">


<div class="bg-white rounded-3xl shadow-xl p-8">


<h1 class="text-3xl font-black text-slate-800">
    Pengesahan Surat
</h1>


<p class="text-slate-500 mt-2">
    {{ $surat->perihal }}
</p>



<hr class="my-6">



<form method="POST"
action="{{ route('pengesahan.proses',$surat->id) }}">


@csrf





<h2 class="font-bold text-xl mb-4">
Pilih Metode Pengesahan
</h2>




<div class="space-y-4">



<label class="
flex
items-center
gap-4
p-5
border
rounded-2xl
cursor-pointer
hover:bg-slate-50
">


<input 
type="radio"
name="metode"
value="qrcode"
checked>


<div>

<p class="font-bold">
Gunakan QR Code
</p>

<p class="text-sm text-slate-500">
Surat akan diberikan kode verifikasi QR.
</p>

</div>


</label>





<label class="
flex
items-center
gap-4
p-5
border
rounded-2xl
cursor-pointer
hover:bg-slate-50
">


<input 
type="radio"
name="metode"
value="tte">


<div>

<p class="font-bold">
Gunakan TTE
</p>

<p class="text-sm text-slate-500">
Menggunakan tanda tangan elektronik pejabat.
</p>

</div>


</label>



</div>






<button
type="submit"
class="
mt-8
w-full
py-4
rounded-xl
bg-blue-600
text-white
font-bold
hover:bg-blue-700
">


Proses Pengesahan


</button>



</form>



</div>


</div>



@endsection