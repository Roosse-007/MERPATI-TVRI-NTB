@extends('layouts.app')


@section('title','Upload TTE')


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
">

Upload Tanda Tangan Elektronik

</h1>


<p class="mt-2 text-slate-500">

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

value="TTE"

>





<label class="
font-bold
block
mb-3
">

Upload File TTE

</label>




<input

type="file"

name="file"

accept=".png,.jpg,.jpeg"

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
bg-green-600
text-white
font-bold
"

>

Simpan TTE

</button>




</form>


</div>


</div>


@endsection