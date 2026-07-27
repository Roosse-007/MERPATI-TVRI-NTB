@extends('layouts.admin')

@section('title','Setting')

@section('content')


<div class="mb-8">

    <h1 class="text-3xl font-bold text-gray-800">
        Pengaturan
    </h1>

    <p class="text-gray-500 mt-2">
        Kelola pengaturan akun dan sistem E-Surat MERPATI TVRI NTB
    </p>

</div>





<div class="space-y-6">





{{-- PROFIL ADMIN --}}

<div class="bg-white rounded-2xl shadow p-8 w-full">


<h2 class="text-xl font-bold mb-6">

Profil Admin

</h2>



<div class="flex items-center gap-8">


<img
src="https://ui-avatars.com/api/?name=Administrator&background=2563eb&color=fff&size=150"
class="w-28 h-28 rounded-full object-cover">



<div>


<h3 class="text-2xl font-bold text-gray-800">

Administrator

</h3>


<p class="text-gray-500 mt-1">

admin@tvri.go.id

</p>



<button

class="mt-5 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

<i class="bi bi-camera mr-2"></i>

Ubah Foto

</button>



</div>


</div>


</div>









{{-- INFORMASI SISTEM --}}

<div class="bg-white rounded-2xl shadow p-8 w-full">


<h2 class="text-xl font-bold mb-6">

Informasi Sistem

</h2>




<label class="text-gray-600">

Nama Aplikasi

</label>



<input

value="MERPATI TVRI NTB"

class="w-full border rounded-lg px-4 py-3 mt-2">



</div>









{{-- KEAMANAN --}}

<div class="bg-white rounded-2xl shadow p-8 w-full">


<h2 class="text-xl font-bold mb-6">

Keamanan

</h2>



<div class="space-y-4">


<input

type="password"

placeholder="Password Lama"

class="w-full border rounded-lg px-4 py-3">





<input

type="password"

placeholder="Password Baru"

class="w-full border rounded-lg px-4 py-3">





<input

type="password"

placeholder="Konfirmasi Password"

class="w-full border rounded-lg px-4 py-3">



</div>


</div>









{{-- NOTIFIKASI --}}

<div class="bg-white rounded-2xl shadow p-8 w-full">


<h2 class="text-xl font-bold mb-6">

Notifikasi

</h2>



<div class="space-y-5">



<label class="flex justify-between items-center">


<span class="text-gray-700">

<i class="bi bi-envelope mr-2"></i>

Notifikasi Email

</span>



<input

type="checkbox"

checked

class="w-5 h-5">



</label>







<label class="flex justify-between items-center">


<span class="text-gray-700">

<i class="bi bi-check-circle mr-2"></i>

Approval Surat

</span>



<input

type="checkbox"

checked

class="w-5 h-5">



</label>








<label class="flex justify-between items-center">


<span class="text-gray-700">

<i class="bi bi-archive mr-2"></i>

Pengingat Arsip

</span>



<input

type="checkbox"

class="w-5 h-5">



</label>





</div>


</div>









{{-- BUTTON --}}


<div class="flex justify-end">


<button

class="bg-blue-700 hover:bg-blue-800 text-white px-8 py-3 rounded-lg shadow">


<i class="bi bi-save mr-2"></i>

Simpan Pengaturan


</button>


</div>






</div>



@endsection