@extends('layouts.app')


@section('title','Upload QR Code')


@section('content')


<div class="max-w-4xl mx-auto">


<div class="
bg-white
rounded-3xl
shadow-xl
p-8
">


<h1 class="
text-3xl
font-black
text-slate-800
">

Upload QR Code Verifikasi

</h1>


<p class="
mt-2
text-slate-500
">

Surat :
<b>
{{ $surat->perihal }}
</b>

</p>



<hr class="my-6">





<form

action="{{ route('pengesahan.upload',$surat->id) }}"

method="POST"

enctype="multipart/form-data"

>


@csrf




<input

type="hidden"

name="metode"

value="QR Code"

>





<label class="
font-bold
block
mb-3
">

Masukkan File QR Code

</label>



<input

type="file"

name="file"

accept=".png,.jpg,.jpeg,.svg"

required

class="
w-full
border
rounded-xl
p-4
"

>




<button

type="submit"

class="
mt-6
px-8
py-4
rounded-xl
bg-purple-600
text-white
font-bold
"

>

Simpan QR Code

</button>




</form>



</div>


</div>


@endsection