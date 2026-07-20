@extends('layouts.app')

@section('title','Tambah User')

@section('content')


<div class="max-w-5xl mx-auto">


<div class="
bg-white
rounded-[32px]
shadow-xl
p-8
">



{{-- HEADER --}}

<div class="mb-8">


<h1 class="
text-4xl
font-black
text-slate-800
">

Tambah User 👤

</h1>


<p class="
text-slate-500
mt-2
">

Tambah akun pengguna baru pada sistem E-Surat MERPATI TVRI NTB

</p>


</div>






<form action="{{ route('users.store') }}" method="POST">

@csrf





<div class="grid md:grid-cols-2 gap-6">



{{-- NAMA --}}

<div>

<label class="font-bold text-slate-700">
Nama Lengkap
</label>


<input
type="text"
name="name"
value="{{old('name')}}"

class="
w-full
mt-2
rounded-xl
border-slate-300
shadow-sm
focus:ring-blue-500
focus:border-blue-500
"
required>


@error('name')

<p class="text-red-500 text-sm mt-1">
{{$message}}
</p>

@enderror


</div>







{{-- USERNAME --}}

<div>


<label class="font-bold text-slate-700">
Username
</label>


<input
type="text"
name="username"
value="{{old('username')}}"

class="
w-full
mt-2
rounded-xl
border-slate-300
"
required>



@error('username')

<p class="text-red-500 text-sm mt-1">
{{$message}}
</p>

@enderror



</div>








{{-- EMAIL --}}

<div>


<label class="font-bold text-slate-700">
Email
</label>


<input
type="email"
name="email"
value="{{old('email')}}"

class="
w-full
mt-2
rounded-xl
border-slate-300
"
required>



@error('email')

<p class="text-red-500 text-sm mt-1">
{{$message}}
</p>

@enderror



</div>







{{-- PASSWORD --}}

<div>


<label class="font-bold text-slate-700">
Password
</label>


<input
type="password"
name="password"

class="
w-full
mt-2
rounded-xl
border-slate-300
"
required>



@error('password')

<p class="text-red-500 text-sm mt-1">
{{$message}}
</p>

@enderror



</div>








{{-- NIP --}}

<div>


<label class="font-bold text-slate-700">
NIP
</label>


<input
type="text"
name="nip"
value="{{old('nip')}}"

class="
w-full
mt-2
rounded-xl
border-slate-300
"
required>




@error('nip')

<p class="text-red-500 text-sm mt-1">
{{$message}}
</p>

@enderror



</div>








{{-- STATUS --}}

<div>


<label class="font-bold text-slate-700">
Status Akun
</label>



<select
name="is_active"

class="
w-full
mt-2
rounded-xl
border-slate-300
">


<option value="1">
Aktif
</option>


<option value="0">
Tidak Aktif
</option>


</select>



</div>




</div>








{{-- UNIT KERJA --}}

<div class="mt-6">


<label class="font-bold text-slate-700">
Unit Kerja
</label>



<select
name="unit_kerja_id"

class="
w-full
mt-2
rounded-xl
border-slate-300
"
required>



<option value="">
-- Pilih Unit Kerja --
</option>



@foreach($unitKerja as $unit)


<option value="{{$unit->id}}"

{{old('unit_kerja_id')==$unit->id?'selected':''}}

>


{{$unit->nama_unit}}


</option>



@endforeach



</select>



@error('unit_kerja_id')

<p class="text-red-500 text-sm mt-1">
{{$message}}
</p>

@enderror



</div>









{{-- JABATAN --}}

<div class="mt-6">


<label class="font-bold text-slate-700">
Jabatan
</label>



<select
name="jabatan_id"

class="
w-full
mt-2
rounded-xl
border-slate-300
"

required>



<option value="">
-- Pilih Jabatan --
</option>



@foreach($jabatan as $jab)


<option value="{{$jab->id}}"

{{old('jabatan_id')==$jab->id?'selected':''}}

>


{{$jab->nama_jabatan}}


</option>



@endforeach



</select>



@error('jabatan_id')

<p class="text-red-500 text-sm mt-1">
{{$message}}
</p>

@enderror



</div>









{{-- ROLE --}}

<div class="mt-6">


<label class="font-bold text-slate-700">
Role
</label>



<select
name="role"

class="
w-full
mt-2
rounded-xl
border-slate-300
"

required>



<option value="">
-- Pilih Role --
</option>



@foreach($roles as $role)


<option value="{{$role->name}}"

{{old('role')==$role->name?'selected':''}}

>


{{$role->name}}


</option>



@endforeach



</select>



@error('role')

<p class="text-red-500 text-sm mt-1">
{{$message}}
</p>

@enderror



</div>









{{-- BUTTON --}}


<div class="
flex
gap-4
mt-10
">



<button

class="
bg-gradient-to-r
from-blue-600
to-cyan-400

text-white

px-8
py-3

rounded-2xl

font-bold

shadow-lg

hover:scale-105

transition
"

type="submit"
>


💾 Simpan User


</button>





<a href="{{route('users.index')}}"

class="
bg-slate-200

text-slate-700

px-8
py-3

rounded-2xl

font-bold

hover:bg-slate-300

transition
">


Kembali


</a>




</div>




</form>



</div>



</div>



@endsection