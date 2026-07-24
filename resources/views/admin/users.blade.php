@extends('layouts.admin')

@section('title','Kelola User')

@section('content')


<!-- HEADER -->

<div class="
    mb-8
    bg-gradient-to-r
    from-blue-50
    via-white
    to-cyan-50
    rounded-2xl
    p-6
    border
    border-slate-200
    shadow-sm
">


<div class="flex items-center justify-between">


    <!-- TITLE -->

    <div class="flex items-center gap-4">


        <div class="
            w-14
            h-14
            rounded-2xl
            bg-gradient-to-br
            from-slate-950
            via-blue-900
            to-blue-700
            flex
            items-center
            justify-center
            text-white
            shadow-lg
        ">

            <i class="bi bi-people-fill text-2xl"></i>

        </div>



        <div>


            <h1 class="
                text-3xl
                font-bold
                text-slate-800
            ">
                Kelola User
            </h1>


            <p class="
                text-slate-500
                text-sm
                mt-1
            ">
                Manajemen pengguna sistem MERPATI TVRI NTB
            </p>


        </div>


    </div>





    <!-- BUTTON -->

    <button
        onclick="openUserModal()"
        class="
            flex
            items-center
            gap-2
            bg-gradient-to-br
from-slate-950
via-blue-900
to-blue-700
hover:from-blue-900
hover:to-blue-600
            text-white
            px-6
            py-3
            rounded-xl
            shadow-lg
            transition
            font-semibold
        ">


        <i class="bi bi-person-plus"></i>

        Tambah User


    </button>




</div>


</div>






<!-- STATISTIK -->

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">


    <!-- TOTAL USER -->
    <div class="
        bg-gradient-to-r from-blue-600 to-cyan-500
        rounded-2xl
        h-32
        px-6
        shadow-md
        text-white
    ">


        <div class="
    flex
    items-center
    justify-between
    h-full
">


            <div class="text-left">


                <p class="text-sm text-blue-100">
                    Total User
                </p>


                <h2 class="
                    text-3xl
                    font-bold
                    mt-1
                ">
                    {{ $totalUser }}
                </h2>


            </div>



            <div class="
                w-12
                h-12
                rounded-xl
                bg-white/20
                flex
                items-center
                justify-center
            ">

                <i class="bi bi-people-fill text-xl"></i>

            </div>


        </div>


    </div>







    <!-- USER AKTIF -->

    <div class="
        bg-gradient-to-r from-emerald-500 to-green-600
        rounded-2xl
        h-32
        px-6
        shadow-md
        text-white
    ">


<div class="
    flex
    items-center
    justify-between
    h-full
">


            <div class="text-left">


                <p class="text-sm text-green-100">
                    User Aktif
                </p>


                <h2 class="
                    text-3xl
                    font-bold
                    mt-1
                ">
                    {{ $userAktif }}
                </h2>


            </div>



            <div class="
                w-12
                h-12
                rounded-xl
                bg-white/20
                flex
                items-center
                justify-center
            ">


                <i class="bi bi-person-check-fill text-xl"></i>


            </div>


        </div>


    </div>









    <!-- NON AKTIF -->


    <div class="
        bg-gradient-to-r from-rose-500 to-red-600
        rounded-2xl
        h-32
        px-6
        shadow-md
        text-white
    ">


        <div class="
    flex
    items-center
    justify-between
    h-full
">


            <div class="text-left">


                <p class="text-sm text-red-100">
                    Non Aktif
                </p>


                <h2 class="
                    text-3xl
                    font-bold
                    mt-1
                ">
                    {{ $userNonAktif }}
                </h2>


            </div>



            <div class="
                w-12
                h-12
                rounded-xl
                bg-white/20
                flex
                items-center
                justify-center
            ">


                <i class="bi bi-person-x-fill text-xl"></i>


            </div>


        </div>


    </div>



</div>

<!-- FILTER -->

<div class="bg-white rounded-2xl shadow-md p-6 mb-6">


<form method="GET" action="{{ route('admin.users') }}">


    <div class="flex items-center gap-4">


        <div class="relative flex-1">


            <i class="bi bi-search absolute left-4 top-1/2 
                      -translate-y-1/2 text-slate-400"></i>


            <input
                name="search"
                value="{{ request('search') }}"
                type="text"
                placeholder="Cari Divisi atau Username..."
                class="
                w-full
                pl-12
                pr-4
                py-3
                rounded-xl
                border
                border-slate-300
                focus:ring-4
                focus:ring-blue-100
                focus:border-blue-500
                outline-none
                "
            >


        </div>



        <button
            type="submit"
            class="
            px-8
            py-3
            rounded-xl
            bg-blue-700
            hover:bg-blue-800
            text-white
            font-semibold
            shadow
            transition">


            <i class="bi bi-search me-2"></i>

            Cari


        </button>


    </div>


</form>


</div>









<!-- TABLE -->


<div class="bg-white rounded-xl shadow overflow-hidden">


<table class="w-full">


<thead class="bg-blue-800 text-white">

<tr>

<th class="px-6 py-4 text-left w-16">
    No
</th>

<th class="px-6 py-4 text-left">
    Divisi
</th>

<th class="px-6 py-4 text-left">
    Username
</th>

<th class="px-6 py-4 text-left">
    Email
</th>

<th class="px-6 py-4 text-center w-40">
    Status
</th>

<th class="px-6 py-4 text-center w-64">
    Aksi
</th>

</tr>

</thead>





<tbody id="userTable">

    @forelse($users as $user)

    <tr class="userRow border-b hover:bg-gray-50 h-16">

        <td class="px-4">
    {{ $loop->iteration }}
</td>

        <td class="px-4 nama">
            {{ $user->name }}
        </td>

        <td class="px-4 username">
            {{ $user->username }}
        </td>

        <td>
            {{ $user->email }}
        </td>

        <td class="text-center">

            @if($user->is_active)

                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                    Aktif
                </span>

            @else

                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
                    Non Aktif
                </span>

            @endif

        </td>

      <td class="text-center align-middle">

    <div class="flex justify-center items-center gap-2">

        <a href="{{ route('users.edit', $user->id) }}"
           class="inline-flex items-center gap-1
                  bg-amber-500 hover:bg-amber-600
                  text-white text-sm font-medium
                  px-4 py-2 rounded-lg
                  transition">

            <i class="bi bi-pencil-square"></i>
            Edit

        </a>

        <form action="{{ route('users.destroy', $user->id) }}"
              method="POST"
              class="delete-form inline">

            @csrf
            @method('DELETE')

            <button
                type="button"
                class="delete-btn inline-flex items-center gap-1
                       bg-red-600 hover:bg-red-700
                       text-white text-sm font-medium
                       px-4 py-2 rounded-lg
                       transition">

                <i class="bi bi-trash"></i>
                Hapus

            </button>

        </form>

    </div>

</td>
    </tr>

    @empty

    <tr>

        <td colspan="6" class="text-center py-6 text-gray-500">

            Belum ada data user.

        </td>

    </tr>

    @endforelse

</tbody>

</table>


</div>









<!-- MODAL -->

<div
id="userModal"
class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm items-center justify-center">


<div class="
    bg-white
    rounded-3xl
    w-[420px]
    shadow-2xl
    overflow-hidden
">



<!-- HEADER MODAL -->

<div class="
    bg-gradient-to-r
    from-slate-950
    via-blue-900
    to-blue-700
    p-6
    text-white
">


<div class="flex items-center gap-3">


<div class="
    w-12
    h-12
    rounded-xl
    bg-white/20
    flex
    items-center
    justify-center
">

<i class="bi bi-person-plus-fill text-2xl"></i>

</div>



<div>

<h2 class="text-xl font-bold">
Tambah User
</h2>

<p class="text-sm text-blue-100">
Buat akun pengguna baru
</p>


</div>


</div>


</div>





<!-- FORM -->

<form action="{{ route('users.store') }}" method="POST">

@csrf


<div class="p-6 space-y-4">



<!-- NAMA -->

<div class="relative">

<i class="bi bi-person absolute left-4 top-3.5 text-slate-400"></i>

<input
name="name"
placeholder="Nama Lengkap"
class="
w-full
pl-11
pr-4
py-3
rounded-xl
border
border-slate-200
focus:ring-4
focus:ring-blue-100
focus:border-blue-500
outline-none
">

</div>





<!-- USERNAME -->

<div class="relative">

<i class="bi bi-at absolute left-4 top-3.5 text-slate-400"></i>


<input
name="username"
placeholder="Username"
autocomplete="off"
class="
w-full
pl-11
pr-4
py-3
rounded-xl
border
border-slate-200
focus:ring-4
focus:ring-blue-100
outline-none
">


</div>





<!-- EMAIL -->

<div class="relative">

<i class="bi bi-envelope absolute left-4 top-3.5 text-slate-400"></i>


<input
name="email"
placeholder="Email"
class="
w-full
pl-11
pr-4
py-3
rounded-xl
border
border-slate-200
focus:ring-4
focus:ring-blue-100
outline-none
">


</div>





<!-- PASSWORD -->

<div class="relative">


<i class="bi bi-lock absolute left-4 top-3.5 text-slate-400"></i>


<input
id="password"
name="password"
type="password"
placeholder="Password"
autocomplete="new-password"
class="
w-full
pl-11
pr-12
py-3
rounded-xl
border
border-slate-200
focus:ring-4
focus:ring-blue-100
outline-none
">


<button
type="button"
onclick="togglePassword()"
class="
absolute
right-4
top-3.5
text-slate-400
">


<i id="eyeIcon" class="bi bi-eye"></i>


</button>


</div>





<!-- STATUS -->


<select
name="is_active"
class="
w-full
px-4
py-3
rounded-xl
border
border-slate-200
focus:ring-4
focus:ring-blue-100
outline-none
">


<option value="1">
Aktif
</option>


<option value="0">
Tidak Aktif
</option>


</select>





<!-- BUTTON -->


<div class="flex gap-3 pt-3">


<button
type="submit"
class="
flex-1
flex
items-center
justify-center
gap-2
bg-gradient-to-br
from-slate-950
via-blue-900
to-blue-700
hover:from-blue-900
hover:to-blue-600
text-white
py-3.5
rounded-2xl
font-semibold
shadow-lg
transition
duration-300
hover:scale-[1.03]
">

<i class="bi bi-save text-lg"></i>

Simpan

</button>




<button
type="button"
onclick="closeUserModal()"
class="
px-6
bg-slate-200
text-slate-700
rounded-xl
hover:bg-slate-300
">


Batal


</button>


</div>


</div>


</form>


</div>


</div>



<script>

function openUserModal(){


editMode=false;


document.getElementById('modalTitle').innerHTML=
"Tambah User";


document.getElementById('userModal')
.classList.remove('hidden');


document.getElementById('userModal')
.classList.add('flex');

function openUserModal(){

editMode=false;

document.getElementById('modalTitle').innerHTML=
"Tambah User";


// kosongkan form saat buka modal
document.getElementById('username').value = "";
document.getElementById('email').value = "";
document.getElementById('password').value = "";


document.getElementById('userModal')
.classList.remove('hidden');


document.getElementById('userModal')
.classList.add('flex');

}


}

// TAMBAHKAN DISINI

function togglePassword(){

    let password =
    document.getElementById('password');


    let icon =
    document.getElementById('eyeIcon');


    if(password.type === "password"){

        password.type = "text";

        icon.classList.remove('bi-eye');

        icon.classList.add('bi-eye-slash');

    }else{

        password.type = "password";

        icon.classList.remove('bi-eye-slash');

        icon.classList.add('bi-eye');

    }

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

let password =
document.getElementById('password').value;





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
-
</td>

<td>
<span class="bg-green-100 text-green-700 px-3 py-1 rounded">

Aktif

</span>
</td>


<td>

</td>


</tr>

`;

}



closeUserModal();


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

@push('scripts')
<script>
document.querySelectorAll('.delete-btn').forEach(button => {

    button.addEventListener('click', function () {

        const form = this.closest('.delete-form');

        Swal.fire({
            title: 'Hapus User?',
            text: 'User ini akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

    });

});
</script>

@endpush


