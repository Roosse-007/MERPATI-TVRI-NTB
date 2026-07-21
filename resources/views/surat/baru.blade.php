@extends('layouts.app')


@section('title','Surat Baru')


@section('content')


<div class="max-w-7xl mx-auto px-8 py-8">
<div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">    
        {{-- Header --}}
        <div class="px-8 py-6 border-b bg-gradient-to-r from-blue-50 to-white">

            <h1 class="text-3xl font-black text-slate-800">
                Surat Baru
            </h1>

            <p class="text-slate-500 mt-1">
                Sistem Informasi Surat Digital TVRI NTB
            </p>

        </div>






    <form
        action="{{ route('surat.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="p-8 space-y-10"
    >

        @csrf

        {{-- ===================== INFORMASI SURAT ===================== --}}
        <div class="rounded-2xl border border-slate-200 overflow-hidden">

            <div class="px-6 py-4 bg-slate-50 border-b">
                <h2 class="text-xl font-bold text-slate-800">
                    📄 Informasi Surat
                </h2>
            </div>

            <div class="p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



    {{-- Jenis Surat --}}
    <div>
        <label class="font-semibold">
            Jenis Surat
        </label>

        <select
            name="jenis_surat_id"
            required
            class="mt-2 w-full rounded-2xl bg-slate-100 px-5 py-4">

            <option value="">
                -- Pilih Jenis Surat --
            </option>

            @foreach($jenisSurat as $jenis)

                <option value="{{ $jenis->id }}">
                    {{ $jenis->nama_jenis }}
                </option>

            @endforeach

        </select>
    </div>

{{-- Nomor Surat --}}
<div>

    <label class="font-semibold">
        Nomor Surat
    </label>

    @php
        $bulanRomawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ];

        $suffix = '/II.26/' . $bulanRomawi[now()->month] . '/' . now()->year;
    @endphp

    <div class="flex mt-2">

        <input
            type="text"
            id="nomor_awal"
            name="nomor_awal"
            required
            placeholder="885/PB.01.02"
            class="w-64 rounded-l-2xl bg-slate-100 px-5 py-4 border-r-0">

        <div
            class="flex items-center px-5 bg-slate-200 rounded-r-2xl font-semibold text-slate-700 whitespace-nowrap">

            {{ $suffix }}

        </div>

    </div>

    <input
        type="hidden"
        id="nomor_surat"
        name="nomor_surat">

</div>

    {{-- Tanggal --}}
    <div>

        <label class="font-semibold">
            Tanggal Surat
        </label>

        <input
            type="date"
            name="tanggal_surat"
            value="{{ date('Y-m-d') }}"
            class="mt-2 w-full rounded-2xl bg-slate-100 px-5 py-4">

    </div>

    {{-- Sifat Surat --}}
    <div>

        <label class="font-semibold">
            Sifat Surat
        </label>

        <select
            name="sifat_surat_id"
            required
            class="mt-2 w-full rounded-2xl bg-slate-100 px-5 py-4">

            <option value="">
                -- Pilih Sifat Surat --
            </option>

            @foreach($sifatSurat as $sifat)

                <option value="{{ $sifat->id }}">
                    {{ $sifat->nama_sifat }}
                </option>

            @endforeach

        </select>

    </div>

    {{-- Deadline --}}
<div>

    <label class="font-semibold">
        Deadline
        <span class="text-slate-400 font-normal">(Opsional)</span>
    </label>

    <input
        type="date"
        name="deadline"
        value="{{ old('deadline') }}"
        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

    <p class="mt-2 text-sm text-slate-500">
        Kosongkan jika surat tidak memiliki batas waktu.
    </p>

</div>
    
</div>



</div>


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

Masukkan Docx/PDF

</p>




<input

type="file"

name="file_surat"

accept=".pdf,.doc,.docx"

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

<script>
const bulanRomawi = [
    '', 'I', 'II', 'III', 'IV', 'V', 'VI',
    'VII', 'VIII', 'IX', 'X', 'XI', 'XII'
];

const sekarang = new Date();

const suffix =
    '/II.26/' +
    bulanRomawi[sekarang.getMonth() + 1] +
    '/' +
    sekarang.getFullYear();

const nomorAwal = document.getElementById('nomor_awal');
const nomorSurat = document.getElementById('nomor_surat');

nomorAwal.addEventListener('input', function () {
    nomorSurat.value = this.value + suffix;
});
</script>

@endsection