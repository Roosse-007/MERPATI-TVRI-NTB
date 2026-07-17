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

Buat Surat Baru ✉️

</h1>


<p class="
text-slate-500
mt-2
">

Buat dan kirim surat resmi melalui sistem MERPATI TVRI NTB

</p>


</div>





{{-- MAIN CARD --}}

<div class="
bg-white
rounded-[32px]
shadow-xl
p-8
">



<form class="space-y-8">



{{-- INFORMASI SURAT --}}

<div>


<h2 class="
text-2xl
font-black
text-slate-800
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

<label class="
font-semibold
text-slate-700
">

Nomor Surat

</label>


<input

type="text"

placeholder="Contoh: 001/TVRI/2026"

class="
mt-2
w-full
rounded-2xl
bg-slate-100
border-none
px-5
py-4
focus:ring-2
focus:ring-blue-500
"

>


</div>




<div>

<label class="
font-semibold
text-slate-700
">

Tanggal Surat

</label>


<input

type="date"

class="
mt-2
w-full
rounded-2xl
bg-slate-100
border-none
px-5
py-4
focus:ring-2
focus:ring-blue-500
"

>


</div>



</div>


</div>







{{-- TUJUAN --}}

<div>


<h2 class="
text-2xl
font-black
text-slate-800
mb-6
">

Tujuan Surat

</h2>



<div class="
grid
md:grid-cols-2
gap-6
">


<div>


<label class="font-semibold">

Kepada

</label>


<select

class="
mt-2
w-full
rounded-2xl
bg-slate-100
px-5
py-4
outline-none
">


<option>
Pilih Tujuan
</option>


<option>
Kepala Bagian Umum
</option>


<option>
Direktur TVRI NTB
</option>


</select>


</div>




<div>


<label class="font-semibold">

Jenis Surat

</label>


<select

class="
mt-2
w-full
rounded-2xl
bg-slate-100
px-5
py-4
outline-none
">


<option>
Pilih Jenis Surat
</option>


<option>
Undangan
</option>


<option>
Pemberitahuan
</option>


<option>
Laporan
</option>


</select>


</div>



</div>


</div>








{{-- DETAIL --}}


<div>


<label class="
font-semibold
">

Perihal

</label>


<input

type="text"

placeholder="Masukkan perihal surat"

class="
mt-2
w-full
rounded-2xl
bg-slate-100
px-5
py-4
outline-none
focus:ring-2
focus:ring-blue-500
"


>


</div>




<div>


<label class="
font-semibold
">

Isi Surat

</label>


<textarea

rows="6"

placeholder="Tulis isi surat..."

class="
mt-2
w-full
rounded-2xl
bg-slate-100
px-5
py-4
outline-none
focus:ring-2
focus:ring-blue-500
"

></textarea>


</div>







{{-- UPLOAD --}}


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

class="
mt-5
"

>


</div>


</div>







{{-- BUTTON --}}


<div class="
flex
justify-end
gap-4
">


<button

type="button"

class="
px-8
py-4
rounded-2xl
bg-slate-100
font-bold
hover:bg-slate-200
transition
">

Simpan Draft

</button>



<button

class="
px-8
py-4
rounded-2xl
bg-gradient-to-r
from-blue-600
to-cyan-400
text-white
font-bold
shadow-lg
hover:scale-105
transition
">

Kirim Surat

</button>


</div>



</form>


</div>


</div>


@endsection