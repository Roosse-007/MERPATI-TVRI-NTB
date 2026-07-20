@extends('layouts.app')


@section('title','Edit Draft Surat')



@section('content')


<div class="max-w-6xl mx-auto">



{{-- HEADER --}}

<div class="mb-8">


<h1 class="
text-4xl
font-black
text-slate-800
">

✏️ Edit Draft Surat

</h1>



<p class="
text-slate-500
mt-2
">

Perbarui surat sebelum dikirim untuk proses approval.

</p>


</div>







<div class="
bg-white
rounded-[32px]
shadow-xl
p-8
">






{{-- FORM UPDATE --}}


<form

action="{{route('surat.update',$draft->id)}}"

method="POST"

enctype="multipart/form-data"

>


@csrf

@method('PUT')







{{-- INFORMASI SURAT --}}


<h2 class="
text-2xl
font-black
mb-6
">

Informasi Surat

</h2>




<div class="
grid
md:grid-cols-2
gap-6
">



<div>


<label class="font-bold">

Nomor Surat

</label>


<input

type="text"

value="{{$draft->nomor_surat}}"

readonly

class="
w-full
mt-2
bg-slate-100
rounded-xl
p-4
"

>


</div>





<div>


<label class="font-bold">

Tanggal Surat

</label>


<input

type="text"

value="{{\Carbon\Carbon::parse($draft->tanggal_surat)->translatedFormat('d F Y')}}"

readonly

class="
w-full
mt-2
bg-slate-100
rounded-xl
p-4
"

>


</div>



</div>









{{-- TUJUAN SURAT --}}


<h2 class="
text-2xl
font-black
mt-10
mb-6
">

Tujuan Surat

</h2>




<label class="font-bold">

Kepada

</label>




<select

name="tujuan_id"

class="
w-full
mt-2
bg-slate-100
rounded-xl
p-4
"

>


<option value="">

-- Pilih Tujuan --

</option>




@foreach($users as $user)


<option

value="{{$user->id}}"


@if(optional($draft->tujuan->first())->user_id == $user->id)

selected

@endif

>


{{$user->name}}


@if($user->jabatan)

- {{$user->jabatan->nama_jabatan}}

@endif


</option>



@endforeach



</select>









{{-- DETAIL SURAT --}}



<h2 class="
text-2xl
font-black
mt-10
mb-6
">

Detail Surat

</h2>





<label class="font-bold">

Perihal

</label>


<input

type="text"

name="perihal"

value="{{$draft->perihal}}"

class="
w-full
mt-2
bg-slate-100
rounded-xl
p-4
"

>






<label class="font-bold block mt-6">

Ringkasan

</label>


<textarea

name="ringkasan"

rows="3"

class="
w-full
mt-2
bg-slate-100
rounded-xl
p-4
"

>{{$draft->ringkasan}}</textarea>






<label class="font-bold block mt-6">

Isi Surat

</label>



<textarea

name="isi_surat"

rows="10"

class="
w-full
mt-2
bg-slate-100
rounded-xl
p-4
"

>{{$draft->isi_surat}}</textarea>









{{-- LAMPIRAN DOKUMEN --}}


<div class="mt-8">


<h2 class="
text-2xl
font-black
text-slate-800
mb-5
">

Lampiran Dokumen

</h2>




<div class="
border-2
border-dashed
border-blue-300
rounded-[28px]
p-10
text-center
bg-blue-50
hover:bg-blue-100
transition
">



<div class="text-5xl">

📂

</div>



<p class="
mt-4
font-bold
text-slate-700
">

Upload File Surat

</p>



<p class="
text-sm
text-slate-500
">

PDF maksimal 10MB

</p>




<input

type="file"

name="file_surat"

accept=".pdf"

class="
mt-5
mx-auto
block
"

>





@if($draft->file_surat)


<div class="
mt-5
bg-white
rounded-xl
p-4
inline-block
">


<p class="
font-bold
text-slate-700
">

File Saat Ini:

</p>




<a

href="{{asset('storage/'.$draft->file_surat)}}"

target="_blank"

class="
text-blue-600
font-bold
hover:underline
"

>

📄 Lihat File Lama

</a>



</div>



@endif




</div>


</div>










{{-- BUTTON UPDATE --}}



<div class="
flex
justify-end
gap-4
mt-10
">



<a

href="{{route('surat.draft')}}"

class="
bg-slate-200
px-6
py-3
rounded-xl
font-bold
"

>

← Kembali

</a>





<button

type="submit"

class="
bg-blue-600
text-white
px-8
py-3
rounded-xl
font-bold
hover:bg-blue-700
"

>

💾 Simpan Perubahan

</button>




</div>





</form>









{{-- FORM KIRIM SURAT --}}


<div class="
border-t
mt-8
pt-8
flex
justify-end
">



<form

action="{{route('surat.submit',$draft->id)}}"

method="POST"

onsubmit="return confirm('Kirim surat untuk proses approval?')"

>


@csrf



<button

type="submit"

class="
bg-green-600
text-white
px-8
py-3
rounded-xl
font-bold
hover:bg-green-700
"

>

📨 Kirim Surat

</button>



</form>


</div>







</div>





</div>


@endsection