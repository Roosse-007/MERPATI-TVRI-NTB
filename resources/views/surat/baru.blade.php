@extends('layouts.app')


@section('title','Surat Baru')


@section('content')


<div class="max-w-6xl mx-auto">


{{-- HEADER --}}

<div class="mb-8">

<h1 class="
text-4xl
font-black
text-slate-800
">
✉️ Buat Surat Baru
</h1>


<p class="
text-slate-500
mt-2
">
Buat surat resmi melalui sistem MERPATI TVRI NTB
</p>


</div>





{{-- CARD --}}

<div class="
bg-white
rounded-[32px]
shadow-xl
p-8
">



<form

action="{{ route('surat.store') }}"

method="POST"

enctype="multipart/form-data"

class="space-y-8"

>


@csrf





{{-- INFORMASI SURAT --}}


<div>


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

<label class="font-semibold">
Nomor Surat
</label>


<input

type="text"

placeholder="Nomor otomatis"

readonly

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





<div>


<label class="font-semibold">
Tanggal Surat
</label>


<input

type="date"

name="tanggal_surat"

value="{{date('Y-m-d')}}"

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


</div>




{{-- TEMPLATE SURAT --}}


<div>


<h2 class="
text-2xl
font-black
mb-6
">
Template Surat
</h2>



<label class="font-semibold">

Pilih Template

</label>




<select

name="template_surat_id"

required

class="
mt-2
w-full
rounded-2xl
bg-slate-100
px-5
py-4
"

>


<option value="">

-- Pilih Template Surat --

</option>



@foreach($templates as $template)


<option

value="{{ $template->id }}"

>


{{ $template->nama_template }}


@if($template->keterangan)

- {{ $template->keterangan }}

@endif


</option>



@endforeach



</select>


<p class="
text-sm
text-slate-500
mt-2
">

Template akan digunakan untuk membuat dokumen Word otomatis.

</p>


</div>

{{-- TUJUAN --}}


<div>


<h2 class="
text-2xl
font-black
mb-6
">
Tujuan Surat
</h2>



<label class="font-semibold">
Kepada
</label>



<select

name="tujuan_id"

required

class="
mt-2
w-full
rounded-2xl
bg-slate-100
px-5
py-4
"

>


<option value="">
-- Pilih Tujuan --
</option>



@foreach($users as $user)

<option value="{{$user->id}}">

{{$user->name}}

@if($user->jabatan)

- {{$user->jabatan->nama_jabatan}}

@endif


</option>


@endforeach


</select>



</div>







{{-- DETAIL SURAT --}}


<div>


<h2 class="
text-2xl
font-black
mb-6
">
Detail Surat
</h2>




<label class="font-semibold">
Perihal
</label>


<input

type="text"

name="perihal"

required

placeholder="Masukkan perihal surat"

class="
mt-2
w-full
rounded-2xl
bg-slate-100
px-5
py-4
"

>





<label class="
font-semibold
block
mt-6
">

Ringkasan

</label>



<textarea

name="ringkasan"

rows="3"

placeholder="Ringkasan surat"

class="
mt-2
w-full
rounded-2xl
bg-slate-100
px-5
py-4
"

></textarea>






<label class="
font-semibold
block
mt-6
">

Isi Surat

</label>



<textarea

name="isi_surat"

rows="8"

required

placeholder="Tulis isi surat..."

class="
mt-2
w-full
rounded-2xl
bg-slate-100
px-5
py-4
"

></textarea>



</div>







{{-- LAMPIRAN --}}


<div>


<h2 class="
text-2xl
font-black
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



</div>



</div>







{{-- BUTTON --}}


<div class="
flex
justify-end
gap-4
pt-5
">





<a

href="{{route('surat.draft')}}"

class="
px-8
py-4
rounded-2xl
bg-slate-100
font-bold
hover:bg-slate-200
transition
"

>

← Batal

</a>







<button

type="submit"

name="action"

value="draft"

class="
px-8
py-4
rounded-2xl
bg-blue-600
text-white
font-bold
shadow-lg
hover:bg-blue-700
transition
"

>

💾 Simpan Draft

</button>







<button

type="submit"

name="action"

value="kirim"

class="
px-8
py-4
rounded-2xl
bg-green-600
text-white
font-bold
shadow-lg
hover:bg-green-700
transition
"

>

📨 Kirim Surat

</button>






</div>





</form>



</div>



</div>


@endsection