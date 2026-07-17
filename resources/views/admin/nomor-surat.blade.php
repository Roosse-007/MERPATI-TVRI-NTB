@extends('layouts.admin')

@section('title', 'Nomor Surat')

@section('content')

<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Nomor Surat
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola format dan penomoran surat MERPATI TVRI NTB.
        </p>

    </div>

    <button
    onclick="openNomorModal()"
    class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-lg shadow transition hover:-translate-y-1">

    + Tambah Nomor Surat

    </button>

</div>

<!-- Card Statistik -->

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-xl shadow p-6">

        <p class="text-gray-500">
            Total Format
        </p>

        <h2 class="text-4xl font-bold text-blue-700 mt-3">
            15
        </h2>

    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <p class="text-gray-500">
            Tahun Aktif
        </p>

        <h2 class="text-4xl font-bold text-green-600 mt-3">
            2026
        </h2>

    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <p class="text-gray-500">
            Nomor Terakhir
        </p>

        <h2 class="text-4xl font-bold text-yellow-500 mt-3">
            00124
        </h2>

    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <p class="text-gray-500">
            Digunakan Hari Ini
        </p>

        <h2 class="text-4xl font-bold text-red-500 mt-3">
            8
        </h2>

    </div>

</div>

<!-- Filter -->

<div class="bg-white rounded-xl shadow p-5 mb-6">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <input
            type="text"
            placeholder="Cari Format..."
            class="border rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-blue-700">

        <select class="border rounded-lg px-4 py-2">

            <option>Semua Tahun</option>
            <option>2026</option>
            <option>2025</option>
            <option>2024</option>

        </select>

        <select class="border rounded-lg px-4 py-2">

            <option>Semua Status</option>
            <option>Aktif</option>
            <option>Nonaktif</option>

        </select>

        <button
            class="bg-blue-700 hover:bg-blue-800 text-white rounded-lg">

            Cari

        </button>

    </div>

</div>

<!-- Table -->

<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="min-w-full">

        <thead class="bg-blue-800 text-white">

            <tr>

                <th class="px-6 py-4 text-left">
                    No
                </th>

                <th class="px-6 py-4 text-left">
                    Format Nomor
                </th>

                <th class="px-6 py-4 text-left">
                    Nomor Terakhir
                </th>

                <th class="px-6 py-4 text-left">
                    Tahun
                </th>

                <th class="px-6 py-4 text-left">
                    Status
                </th>

                <th class="px-6 py-4 text-center">
                    Aksi
                </th>

            </tr>

        </thead>

        <tbody>

            <tr class="border-b hover:bg-gray-50">

                <td class="px-6 py-4">
                    1
                </td>

                <td class="px-6 py-4 font-medium">
                    001/TVRI/NTB/VII/2026
                </td>

                <td class="px-6 py-4">
                    00124
                </td>

                <td class="px-6 py-4">
                    2026
                </td>

                <td class="px-6 py-4">

                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                        Aktif

                    </span>

                </td>

                <td class="px-6 py-4 text-center">

                    <button
                    onclick="editNomor(this)"
                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded">

                    Edit

                    </button>


                    <button
                    onclick="hapusNomor(this)"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded ml-2">

                    Hapus

                    </button>

                </td>

            </tr>

            <tr class="border-b hover:bg-gray-50">

                <td class="px-6 py-4">
                    2
                </td>

                <td class="px-6 py-4 font-medium">
                    001/DISPOSISI/VII/2026
                </td>

                <td class="px-6 py-4">
                    00075
                </td>

                <td class="px-6 py-4">
                    2026
                </td>

                <td class="px-6 py-4">

                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                        Aktif

                    </span>

                </td>

                <td class="px-6 py-4 text-center">

                    <button
                    onclick="editNomor(this)"
                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded">

                    Edit

                    </button>


                    <button
                    onclick="hapusNomor(this)"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded ml-2">

                    Hapus

                    </button>

                </td>

            </tr>

            <tr class="hover:bg-gray-50">

                <td class="px-6 py-4">
                    3
                </td>

                <td class="px-6 py-4 font-medium">
                    001/INTERNAL/2025
                </td>

                <td class="px-6 py-4">
                    00358
                </td>

                <td class="px-6 py-4">
                    2025
                </td>

                <td class="px-6 py-4">

                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">

                        Nonaktif

                    </span>

                </td>

                <td class="px-6 py-4 text-center">

                    <button
                    onclick="editNomor(this)"
                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded">

                    Edit

                    </button>


                    <button
                    onclick="hapusNomor(this)"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded ml-2">

                    Hapus

                    </button>

                </td>

            </tr>

        </tbody>

    </table>

</div>

<!-- Pagination -->

<div class="mt-6 flex justify-between items-center">

    <p class="text-gray-500">

        Menampilkan 1 - 3 dari 15 format nomor surat

    </p>

    <div class="space-x-2">

        <button class="border px-4 py-2 rounded">

            Sebelumnya

        </button>

        <button class="bg-blue-700 text-white px-4 py-2 rounded">

            1

        </button>

        <button class="border px-4 py-2 rounded">

            2

        </button>

        <button class="border px-4 py-2 rounded">

            Selanjutnya

        </button>

    </div>

</div>

<!-- MODAL TAMBAH NOMOR SURAT -->

<div
id="nomorModal"
class="hidden fixed inset-0 bg-gradient-to-br from-slate-950 via-blue-900 to-blue-600 items-center justify-center z-50">


<div class="bg-white rounded-2xl p-8 w-96 shadow-2xl">


<h2 class="text-xl font-bold mb-5">

Tambah Nomor Surat

</h2>



<input
id="formatNomor"
type="text"
placeholder="Format Nomor Surat"
class="border w-full p-3 rounded-lg mb-3">



<input
id="nomorTerakhir"
type="text"
placeholder="Nomor Terakhir"
class="border w-full p-3 rounded-lg mb-3">



<input
id="tahunNomor"
type="text"
value="2026"
placeholder="Tahun"
class="border w-full p-3 rounded-lg mb-5">



<div class="flex gap-3">


<button
onclick="simpanNomor()"
class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 rounded-lg">

Simpan

</button>



<button
onclick="closeNomorModal()"
class="bg-gray-300 hover:bg-gray-400 px-5 py-2 rounded-lg">

Batal

</button>


</div>


</div>


</div>
<div
id="editModal"
class="hidden fixed inset-0 bg-gradient-to-br from-slate-950 via-blue-900 to-blue-600 items-center justify-center z-50">


<div class="bg-white rounded-2xl p-8 w-96 shadow-xl">


<h2 class="text-xl font-bold mb-5">
Edit Nomor Surat
</h2>


<input
id="editFormat"
class="border w-full p-3 rounded-lg mb-3">


<input
id="editNomor"
class="border w-full p-3 rounded-lg mb-3">


<input
id="editTahun"
class="border w-full p-3 rounded-lg mb-5">


<button
onclick="updateNomor()"
class="bg-blue-700 text-white px-5 py-2 rounded-lg">

Simpan

</button>


<button
onclick="closeEditModal()"
class="bg-gray-300 px-5 py-2 rounded-lg">

Batal

</button>


</div>


</div>
<script>

let editRow = null;



function openNomorModal(){

let modal =
document.getElementById('nomorModal');

modal.classList.remove('hidden');

modal.classList.add('flex');

}



function closeNomorModal(){

let modal =
document.getElementById('nomorModal');

modal.classList.add('hidden');

modal.classList.remove('flex');

}




function simpanNomor(){


let format =
document.getElementById('formatNomor').value;


let nomor =
document.getElementById('nomorTerakhir').value;


let tahun =
document.getElementById('tahunNomor').value;



if(format=="" || nomor==""){

alert("Data belum lengkap");

return;

}



let tbody=document.querySelector("tbody");


tbody.innerHTML += `

<tr class="border-b hover:bg-gray-50">


<td class="px-6 py-4">
Baru
</td>


<td class="px-6 py-4">
${format}
</td>


<td class="px-6 py-4">
${nomor}
</td>


<td class="px-6 py-4">
${tahun}
</td>


<td class="px-6 py-4">

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Aktif

</span>

</td>


<td class="px-6 py-4">


<button onclick="editNomor(this)"
class="bg-yellow-500 text-white px-3 py-2 rounded">

Edit

</button>


<button onclick="hapusNomor(this)"
class="bg-red-600 text-white px-3 py-2 rounded">

Hapus

</button>


</td>


</tr>

`;



closeNomorModal();


}







function editNomor(btn){


editRow = btn.closest("tr");


let data =
editRow.querySelectorAll("td");


document.getElementById("editFormat").value =
data[1].innerText;


document.getElementById("editNomor").value =
data[2].innerText;


document.getElementById("editTahun").value =
data[3].innerText;



let modal=document.getElementById("editModal");


modal.classList.remove("hidden");

modal.classList.add("flex");


}





function updateNomor(){


let data =
editRow.querySelectorAll("td");



data[1].innerText =
document.getElementById("editFormat").value;



data[2].innerText =
document.getElementById("editNomor").value;



data[3].innerText =
document.getElementById("editTahun").value;



alert("Data berhasil diperbarui");


closeEditModal();


}





function closeEditModal(){

let modal=document.getElementById("editModal");

modal.classList.add("hidden");

}




function hapusNomor(btn){


if(confirm("Yakin hapus nomor surat?")){


btn.closest("tr").remove();


}


}




</script>

@endsection