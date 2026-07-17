@extends('layouts.admin')

@section('title','Setting')

@section('content')


<!-- HEADER -->

<div class="mb-8">


<h1 class="text-3xl font-bold text-gray-800">

Pengaturan Sistem

</h1>


<p class="text-gray-500 mt-2">

Kelola konfigurasi aplikasi MERPATI TVRI NTB

</p>


</div>









<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">






<!-- PROFILE -->


<div class="bg-white rounded-2xl shadow p-6">


<div class="text-center">



<img
id="fotoProfil"
src="https://ui-avatars.com/api/?name=Administrator&background=2563eb&color=fff&size=150"
class="w-32 h-32 rounded-full mx-auto object-cover">



<input
type="file"
id="uploadFoto"
accept="image/*"
class="hidden"
onchange="previewFoto(event)">



<h2 class="text-xl font-bold mt-4">

Administrator

</h2>



<p class="text-gray-500">

admin@tvri.go.id

</p>



<button

onclick="document.getElementById('uploadFoto').click()"

class="mt-4 bg-blue-700 text-white px-5 py-2 rounded-lg">

Ganti Foto

</button>



</div>






<hr class="my-6">





<div class="space-y-3">


<button

onclick="openProfilModal()"

class="w-full bg-blue-700 hover:bg-blue-800 text-white py-3 rounded-lg">

Edit Profil

</button>




<button

onclick="logout()"

class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg">

Logout

</button>


</div>



</div>









<!-- KANAN -->


<div class="lg:col-span-2 space-y-6">







<!-- INFORMASI -->


<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-6">

Informasi Aplikasi

</h2>




<div class="grid md:grid-cols-2 gap-5">



<div>

<label>
Nama Aplikasi
</label>

<input
id="namaApp"
value="MERPATI TVRI NTB"
class="w-full border rounded-lg px-4 py-2 mt-2">


</div>






<div>

<label>
Versi
</label>

<input
value="1.0.0"
class="w-full border rounded-lg px-4 py-2 mt-2">


</div>






<div>

<label>
Email Admin
</label>

<input
value="admin@tvri.go.id"
class="w-full border rounded-lg px-4 py-2 mt-2">


</div>






<div>

<label>
Telepon
</label>

<input
value="0370-123456"
class="w-full border rounded-lg px-4 py-2 mt-2">


</div>



</div>


</div>









<!-- PASSWORD -->


<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-6">

Ubah Password

</h2>



<div class="space-y-4">



<input
type="password"
placeholder="Password Lama"
class="w-full border rounded-lg px-4 py-2">





<input
type="password"
placeholder="Password Baru"
class="w-full border rounded-lg px-4 py-2">





<input
type="password"
placeholder="Konfirmasi Password"
class="w-full border rounded-lg px-4 py-2">



</div>


</div>









<!-- NOTIFIKASI -->


<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-6">

Pengaturan Notifikasi

</h2>



<div class="space-y-5">



<label class="flex justify-between items-center">


<span>

Email Notifikasi

</span>


<input
type="checkbox"
checked
class="w-5 h-5">


</label>





<label class="flex justify-between items-center">


<span>

Approval Surat

</span>


<input
type="checkbox"
checked
class="w-5 h-5">


</label>





<label class="flex justify-between items-center">


<span>

Arsip Otomatis

</span>


<input
type="checkbox"
class="w-5 h-5">


</label>



</div>


</div>









<!-- BUTTON -->


<div class="flex justify-end gap-3">


<button

onclick="resetSetting()"

class="px-6 py-3 rounded-lg bg-gray-300 hover:bg-gray-400">


Reset


</button>





<button

onclick="saveSetting()"

class="px-6 py-3 rounded-lg bg-blue-700 text-white hover:bg-blue-800">


Simpan Perubahan


</button>



</div>





</div>


</div>









<!-- MODAL EDIT PROFIL -->


<div

id="profilModal"

class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">



<div class="bg-white rounded-xl p-8 w-96">



<h2 class="text-xl font-bold mb-5">

Edit Profil

</h2>




<input
value="Administrator"
class="border w-full p-3 rounded mb-3">





<input
value="admin@tvri.go.id"
class="border w-full p-3 rounded mb-3">





<button

onclick="closeProfilModal()"

class="bg-gray-300 px-5 py-2 rounded">


Tutup


</button>



</div>



</div>









<script>


function openProfilModal(){


let modal=document.getElementById('profilModal');


modal.classList.remove('hidden');


modal.classList.add('flex');


}





function closeProfilModal(){


let modal=document.getElementById('profilModal');


modal.classList.add('hidden');


}





function previewFoto(event){


let image =
document.getElementById('fotoProfil');


image.src =
URL.createObjectURL(event.target.files[0]);


}






function saveSetting(){


alert(
"Pengaturan berhasil disimpan"
);


}





function resetSetting(){


document.getElementById('namaApp').value =
"MERPATI TVRI NTB";


alert(
"Pengaturan dikembalikan"
);


}





function logout(){


let confirmLogout =
confirm("Yakin ingin logout?");



if(confirmLogout){

alert("Logout berhasil");

}


}



</script>


@endsection