@extends('layouts.app')

@section('title','Disposisi Surat')

@section('content')


<div class="relative">

<x-flying-dove />


{{-- HEADER --}}

<div class="mb-8">


<h1 class="
text-4xl
font-black
text-slate-800
">

Disposisi Surat 📌

</h1>


<p class="
text-slate-500
mt-2
">

Kelola alur penerusan surat antar bagian secara digital

</p>


</div>





{{-- SURAT AKTIF --}}

<div class="
relative
overflow-hidden
bg-gradient-to-r
from-blue-700
via-blue-600
to-cyan-400
rounded-[32px]
p-8
text-white
shadow-xl
">


<div class="
absolute
right-0
top-0
w-80
h-80
bg-white/20
rounded-full
blur-3xl
"></div>



<div class="relative">


<div class="
flex
justify-between
items-start
">


<div>


<p class="text-blue-100">
    Surat Aktif
</p>

<h2 class="text-3xl font-black mt-3">
    {{ $surat->perihal }}
</h2>

<p class="mt-3 text-blue-100">
    Nomor :
    <span class="font-semibold">
        {{ $surat->nomor_surat }}
    </span>
</p>

<p class="mt-2 text-blue-100">
    Pengirim :
    <span class="font-semibold">
        {{ $surat->pengirim->name }}
    </span>
</p>

<p class="mt-2 text-blue-100">
    Tanggal :
    <span class="font-semibold">
        {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}
    </span>
</p>


</div>



<span class="
bg-white/20
px-5
py-3
rounded-2xl
font-bold
">

{{ $surat->prioritasSurat->nama_prioritas ?? '-' }}

</span>


</div>



</div>


</div>








{{-- FLOW DISPOSISI --}}

<div class="
mt-10
bg-white
rounded-[32px]
shadow-xl
p-10
">


<h2 class="
text-2xl
font-black
text-slate-800
">

Alur Disposisi

</h2>




<div class="
mt-10
grid
md:grid-cols-4
gap-6
">


@forelse($surat->disposisi as $item)

<div class="relative bg-slate-50 rounded-[28px] p-6 text-center hover:-translate-y-2 transition">

    <div class="text-5xl">

        👤

    </div>

    <h3 class="mt-4 font-black">

        {{ $item->keUser->name }}

    </h3>

    <p class="text-slate-500 mt-2">

        {{ $item->keUser->jabatan->nama_jabatan ?? '-' }}

    </p>

</div>

@empty

<p class="text-slate-500">

Belum ada disposisi.

</p>

@endforelse


</div>



</div>








{{-- DETAIL DISPOSISI --}}

<div class="
mt-10
grid
md:grid-cols-2
gap-8
">





{{-- CATATAN --}}

<div class="
bg-white
rounded-[32px]
shadow-xl
p-8
">


<h2 class="
text-2xl
font-black
mb-6
">

Instruksi

</h2>



<div class="
bg-blue-50
rounded-2xl
p-5
text-slate-700
">


@if($surat->disposisi->isNotEmpty())

{{ $surat->disposisi->last()->instruksi }}

@else

Belum ada instruksi.

@endif


</div>



<div class="mt-6">


<p class="
text-sm
text-slate-400
">

Dibuat oleh

</p>


<p class="font-bold">

{{ $surat->pengirim->name }}

</p>


</div>


</div>






{{-- STATUS DISPOSISI --}}

<div class="
bg-white
rounded-[32px]
shadow-xl
p-8
">

    <h2 class="
    text-2xl
    font-black
    mb-6
    ">
        Status Disposisi
    </h2>

    <div class="space-y-5">

        @forelse($surat->disposisi as $item)

            <div class="flex justify-between items-center bg-slate-50 rounded-2xl p-5">

                <div>

                    <p class="font-bold">
                        {{ $item->keUser->name }}
                    </p>

                    <p class="text-sm text-slate-500">
                        {{ $item->instruksi }}
                    </p>

                </div>

                <span
                    class="px-4 py-2 rounded-xl font-bold
                    @if($item->status == 'Aktif')
                        bg-blue-100 text-blue-700
                    @elseif($item->status == 'Selesai')
                        bg-green-100 text-green-700
                    @else
                        bg-gray-100 text-gray-700
                    @endif">

                    {{ $item->status }}

                </span>

            </div>

        @empty

            <p class="text-slate-500">
                Belum ada disposisi.
            </p>

        @endforelse

    </div>

</div>



<span class="
bg-green-100
text-green-600
px-4
py-2
rounded-xl
font-bold
">

Selesai

</span>


</div>





<div class="
flex
justify-between
items-center
bg-orange-50
rounded-2xl
p-5
">


<div>

<p class="font-bold">

Staff Pelaksana

</p>


<p class="text-sm text-slate-500">

Menunggu tindakan

</p>


</div>



<span class="
bg-orange-100
text-orange-600
px-4
py-2
rounded-xl
font-bold
">

Pending

</span>


</div>



</div>


</div>



</div>








{{-- BUAT DISPOSISI --}}


<form
method="POST"
action="{{ route('surat.disposisi.store') }}"
class="
mt-10
bg-white
rounded-[32px]
shadow-xl
p-8
">

@csrf

<input
type="hidden"
name="surat_id"
value="{{ $surat->id }}">


<h2 class="
text-2xl
font-black
mb-6
">

Buat Disposisi Baru

</h2>



<div class="
grid
md:grid-cols-2
gap-6
">



<div>


<label class="font-bold">

Tujuan Bagian

</label>


<select
name="ke_user_id"
class="
mt-2
w-full
rounded-2xl
bg-slate-100
px-5
py-4
">

<option value="">Pilih Tujuan</option>

@foreach($users as $user)

<option value="{{ $user->id }}">
    {{ $user->name }}
    @if($user->jabatan)
        - {{ $user->jabatan->nama_jabatan }}
    @endif
</option>

@endforeach

</select>

<option>
Produksi
</option>

<option>
Administrasi
</option>

</select>


</div>




<div>




<input

type="date"

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




<textarea
name="instruksi"

rows="4"

placeholder="Tambahkan instruksi disposisi..."

class="
mt-6
w-full
rounded-2xl
bg-slate-100
px-5
py-4
"

></textarea>



<button
type="submit"
class="
mt-6
bg-gradient-to-r
from-blue-600
to-cyan-400
text-white
px-8
py-4
rounded-2xl
font-bold
shadow-lg
hover:scale-105
transition
">

Kirim Disposisi

</button>



</form>


@endsection