@extends('layouts.admin')

@section('title','Kelola User')

@section('content')


<div class="flex justify-between items-center mb-8">


<div>

<h1 class="text-3xl font-bold text-gray-800">
Kelola User
</h1>


<p class="text-gray-500 mt-2">
Data pengguna sistem MERPATI TVRI NTB
</p>


</div>



<button
onclick="openUserModal()"
class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-lg shadow">


+ Tambah User


</button>


</div>






<!-- STATISTIK -->


<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">


<div class="bg-white rounded-xl shadow p-6">

<p class="text-gray-500">
Total User
</p>

<h2 class="text-4xl font-bold text-blue-700 mt-3">
58
</h2>

</div>




<div class="bg-white rounded-xl shadow p-6">

<p class="text-gray-500">
User Aktif
</p>

<h2 class="text-4xl font-bold text-green-600 mt-3">
52
</h2>

</div>




<div class="bg-white rounded-xl shadow p-6">

<p class="text-gray-500">
Non Aktif
</p>

<h2 class="text-4xl font-bold text-red-600 mt-3">
6
</h2>

</div>


</div>









<!-- FILTER -->


<div class="bg-white rounded-xl shadow p-5 mb-6">


<div class="grid md:grid-cols-3 gap-4">


<input
id="searchUser"
type="text"
placeholder="Cari Nama..."
class="border rounded-lg px-4 py-2">





<select
id="filterRole"
class="border rounded-lg px-4 py-2">


<option value="Semua">
Semua Role
</option>


<option value="Admin">
Admin
</option>


<option value="Operator">
Operator
</option>


<option value="Pimpinan">
Pimpinan
</option>


</select>





<button
onclick="filterUser()"
class="bg-blue-700 text-white rounded-lg">


Cari


</button>


</div>


</div>









<!-- TABLE -->


<div class="bg-white rounded-xl shadow overflow-hidden">


<table class="w-full">


<thead class="bg-blue-800 text-white">


<tr>


<th class="p-4 text-left">
No
</th>


<th class="text-left">
Nama
</th>


<th class="text-left">
Username
</th>


<th class="text-left">
Email
</th>


<th class="text-left">
Role
</th>


<th>
Status
</th>


<th>
Aksi
</th>


</tr>


</thead>





<tbody id="userTable">



<tr class="userRow border-b">


<td class="p-4">
1
</td>


<td class="nama">
Administrator
</td>


<td class="username">
admin
</td>


<td>
admin@tvri.go.id
</td>


<td class="role">

Admin

</td>


<td>

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Aktif

</span>

</td>


<td>


<button
onclick="editUser(this)"
class="bg-yellow-500 text-white px-3 py-2 rounded">


Edit


</button>



<button
onclick="hapusUser(this)"
class="bg-red-600 text-white px-3 py-2 rounded">


Hapus


</button>


</td>


</tr>







<tr class="userRow border-b">


<td class="p-4">
2
</td>


<td class="nama">
Operator Surat
</td>


<td class="username">
operator
</td>


<td>
operator@tvri.go.id
</td>


<td class="role">

Operator

</td>


<td>

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Aktif

</span>

</td>


<td>


<button
onclick="editUser(this)"
class="bg-yellow-500 text-white px-3 py-2 rounded">

Edit

</button>


<button
onclick="hapusUser(this)"
class="bg-red-600 text-white px-3 py-2 rounded">

Hapus

</button>


</td>


</tr>




</tbody>


</table>


</div>









<!-- MODAL -->


<div
id="userModal"
class="hidden fixed inset-0 bg-gradient-to-br from-slate-950 via-blue-900 to-blue-600 items-center justify-center">


<div class="bg-white rounded-2xl p-8 w-96 shadow-2xl">


<h2
id="modalTitle"
class="text-xl font-bold mb-5">

Tambah User

</h2>



<input
id="nama"
placeholder="Nama"
class="border w-full p-3 rounded mb-3">



<input
id="username"
placeholder="Username"
class="border w-full p-3 rounded mb-3">



<input
id="email"
placeholder="Email"
class="border w-full p-3 rounded mb-3">



<select
id="role"
class="border w-full p-3 rounded mb-3">


<option>
Admin
</option>


<option>
Operator
</option>


<option>
Pimpinan
</option>


</select>



<button
onclick="simpanUser()"
class="bg-blue-700 text-white px-5 py-2 rounded">


Simpan


</button>



<button
onclick="closeUserModal()"
class="bg-gray-300 px-5 py-2 rounded">


Batal


</button>


</div>


</div>









<script>


let editMode=false;

let editRow=null;



function openUserModal(){


editMode=false;


document.getElementById('modalTitle').innerHTML=
"Tambah User";


document.getElementById('userModal')
.classList.remove('hidden');


document.getElementById('userModal')
.classList.add('flex');


}




function closeUserModal(){


document.getElementById('userModal')
.classList.add('hidden');


}






function simpanUser(){


let nama =
document.getElementById('nama').value;


let username =
document.getElementById('username').value;


let email =
document.getElementById('email').value;


let role =
document.getElementById('role').value;



if(editMode){


editRow.querySelector('.nama').innerHTML=nama;

editRow.querySelector('.username').innerHTML=username;

editRow.querySelector('.role').innerHTML=role;


}

else{


let table =
document.getElementById('userTable');



table.innerHTML += `

<tr class="userRow border-b">

<td class="p-4">
Baru
</td>

<td class="nama">
${nama}
</td>

<td class="username">
${username}
</td>

<td>
${email}
</td>

<td class="role">
${role}
</td>

<td>
<span class="bg-green-100 text-green-700 px-3 py-1 rounded">

Aktif

</span>
</td>


<td>

<button onclick="editUser(this)"
class="bg-yellow-500 text-white px-3 py-2 rounded">

Edit

</button>


<button onclick="hapusUser(this)"
class="bg-red-600 text-white px-3 py-2 rounded">

Hapus

</button>


</td>


</tr>

`;

}



closeUserModal();


}







function editUser(btn){


editMode=true;


editRow=
btn.closest('tr');



document.getElementById('modalTitle').innerHTML=
"Edit User";


document.getElementById('nama').value=
editRow.querySelector('.nama').innerText;


document.getElementById('username').value=
editRow.querySelector('.username').innerText;



document.getElementById('role').value=
editRow.querySelector('.role').innerText;



openUserModal();


}






function hapusUser(btn){


if(confirm("Yakin hapus user?")){


btn.closest('tr').remove();


}


}








function filterUser(){


let keyword =
document.getElementById('searchUser')
.value.toLowerCase();


let role =
document.getElementById('filterRole')
.value;



document.querySelectorAll('.userRow')
.forEach(row=>{


let nama =
row.querySelector('.nama')
.innerText.toLowerCase();



let roleData =
row.querySelector('.role')
.innerText.trim();



if(

nama.includes(keyword)

&&

(role=="Semua" || role==roleData)

){


row.style.display="table-row";


}

else{


row.style.display="none";


}



});



}


</script>


@endsection