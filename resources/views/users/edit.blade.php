@extends('layouts.app')


@section('title','Edit Draft Surat')


@section('content')


<div class="max-w-6xl mx-auto">


<div class="mb-8">

<h1 class="text-4xl font-black text-slate-800">

✏️ Edit Draft Surat

</h1>


<p class="text-slate-500 mt-2">

Perbarui data surat sebelum dikirim.

</p>


</div>





<div class="bg-white rounded-[32px] shadow-xl p-8">



<form action="{{route('surat.update',$draft->id)}}"
method="POST">


@csrf

@method('PUT')





{{-- INFORMASI SURAT --}}


<h2 class="text-2xl font-black mb-6">

📄 Informasi Surat

</h2>




<div class="grid md:grid-cols-2 gap-6">



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
bg-slate-100
rounded-xl
p-4
mt-2
"

>


</div>





<div>

<label class="font-bold">

Tanggal Surat

</label>


<input

type="date"

value="{{date('Y-m-d',strtotime($draft->tanggal_surat))}}"

readonly

class="
w-full
bg-slate-100
rounded-xl
p-4
mt-2
"


>


</div>



</div>








{{-- TUJUAN --}}


<h2 class="text-2xl font-black mt-8 mb-6">

👤 Tujuan Surat

</h2>




<div>


<label class="font-bold">

Kepada

</label>


<select

name="tujuan_id"

class="
w-full
bg-slate-100
rounded-xl
p-4
mt-2
"


>


<option value="">

-- Pilih Tujuan --

</option>



@foreach($users as $user)


<option

value="{{$user->id}}"


@if(
optional($draft->tujuan->first())->user_id == $user->id
)

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


</div>








{{-- DETAIL SURAT --}}



<h2 class="text-2xl font-black mt-8 mb-6">

📝 Detail Surat

</h2>




<div class="grid md:grid-cols-2 gap-6">



<div>


<label class="font-bold">

Perihal

</label>


<input

type="text"

name="perihal"

value="{{old('perihal',$draft->perihal)}}"

class="
w-full
bg-slate-100
rounded-xl
p-4
mt-2
"

>


</div>





<div>


<label class="font-bold">

Ringkasan

</label>


<input

type="text"

name="ringkasan"

value="{{old('ringkasan',$draft->ringkasan)}}"

class="
w-full
bg-slate-100
rounded-xl
p-4
mt-2
"

>


</div>



</div>







<label class="font-bold block mt-6">

Isi Surat

</label>


<textarea

name="isi_surat"

rows="10"

class="
w-full
bg-slate-100
rounded-xl
p-4
mt-2
"

>{{old('isi_surat',$draft->isi_surat)}}</textarea>









{{-- BUTTON --}}


<div class="flex justify-end gap-4 mt-8">





<a href="{{route('surat.draft')}}"

class="
bg-slate-200
px-6
py-3
rounded-xl
font-bold
hover:bg-slate-300
transition
">

Kembali

</a>






{{-- SIMPAN --}}


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
transition
">

💾 Simpan Perubahan

</button>





</div>




</form>





{{-- KIRIM SURAT --}}

<form

action="{{route('surat.submit',$draft->id)}}"

method="POST"

onsubmit="return confirm('Apakah surat ini sudah siap dikirim untuk proses approval?')"

class="flex justify-end mt-4"


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
transition
">

📨 Kirim Surat

</button>


</form>





</div>


</div>




@endsection