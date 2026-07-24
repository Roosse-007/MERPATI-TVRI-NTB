@extends('layouts.app')


@section('title','Detail Surat')


@section('content')


<div class="
w-full
max-w-full
px-6
py-8
">









{{-- ================= INFORMASI SURAT ================= --}}

<div class="
bg-white
rounded-3xl
shadow-xl
border
border-slate-200
relative
mb-8
">


{{-- HEADER CARD --}}

<div class="
px-10
py-8
bg-gradient-to-r
from-blue-50
to-white
border-b
">


<div class="
flex
justify-between
items-start
gap-5
">


<div>


<h2 class="
text-3xl
font-black
text-slate-800
">

{{ $surat->perihal }}

</h2>



<p class="
mt-3
text-slate-500
">

Nomor Surat :

<span class="
font-bold
text-slate-800
">

{{ $surat->nomor_surat }}

</span>

</p>

@if($surat->parent_surat_id)

<div class="
mt-4
bg-purple-50
border
border-purple-200
rounded-xl
p-4
">


<p class="
text-sm
text-purple-600
font-bold
">

Membalas Surat


</p>


<p class="
font-bold
text-slate-800
">

Nomor:

{{ $surat->suratInduk->nomor_surat ?? '-' }}


</p>



<p class="
text-sm
text-slate-500
">

{{ $surat->suratInduk->perihal ?? '-' }}

</p>


</div>


@endif
</div>




<span
class="
inline-flex
items-center
gap-2
mt-2
px-5
py-3
rounded-full
font-bold

@if($surat->status == 'Menunggu Approval')

bg-yellow-100 text-yellow-700

@elseif($surat->status == 'Disetujui')

bg-green-100 text-green-700

@elseif($surat->status == 'Ditolak')

bg-red-100 text-red-700

@else

bg-slate-100 text-slate-700

@endif
">


@if($surat->status == 'Menunggu Approval')

<i class="fa-solid fa-clock"></i>

@elseif($surat->status == 'Disetujui')

<i class="fa-solid fa-check"></i>

@elseif($surat->status == 'Ditolak')

<i class="fa-solid fa-xmark"></i>

@endif


{{ $surat->status }}


</span>


</div>


</div>







{{-- DETAIL --}}

<div class="
p-10
grid
md:grid-cols-3
gap-10
">





<div>

<p class="text-slate-400 text-sm">
Jenis Surat
</p>

<p class="font-bold text-lg">
{{ $surat->jenisSurat->nama_jenis ?? '-' }}
</p>

</div>






<div>

<p class="text-slate-400 text-sm">
Tanggal Surat
</p>


<p class="font-bold text-lg">

{{ $surat->tanggal_surat?->format('d M Y') }}

</p>


</div>







<div>

<p class="text-slate-400 text-sm">
Sifat Surat
</p>


<p class="font-bold text-lg">

{{ $surat->sifatSurat->nama_sifat ?? '-' }}

</p>


</div>







<div>


<p class="text-slate-400 text-sm">

Deadline

</p>


<p class="
font-bold
text-red-600
">

{{ $surat->deadline ?? '-' }}

</p>


</div>







<div>


<p class="text-slate-400 text-sm">

Pengirim

</p>


<p class="font-bold">

{{ $surat->pengirim->name ?? '-' }}

</p>


<p class="text-sm text-slate-500">

{{ $surat->pengirim->jabatan->nama_jabatan ?? '' }}

</p>


</div>







<div>


<p class="text-slate-400 text-sm">

Tujuan

</p>



@forelse($surat->tujuan as $tujuan)


<p class="font-bold">

{{ $tujuan->user->name ?? '-' }}

</p>


@empty


<p class="font-bold">

-

</p>


@endforelse


</div>



</div>








{{-- BUTTON --}}

<div class="
px-10
pb-10
flex
gap-4
">


<a href="{{ url()->previous() }}"
class="
px-6
py-3
rounded-xl
bg-slate-100
font-bold
hover:bg-slate-200
">

Kembali

</a>




<div class="relative">


<button
onclick="toggleFollow()"
class="
px-6
py-3
rounded-xl
bg-blue-600
text-white
font-bold
">

Tindak Lanjut ▾

</button>



{{-- DROPDOWN --}}

<div

id="followMenu"

class="
hidden
absolute
top-full
right-0
mt-3
bg-white
shadow-xl
rounded-xl
w-60
overflow-hidden
z-[999]
border
border-slate-200
">


<a href="{{ route('surat.disposisi',$surat->id) }}"
class="
flex
items-center
px-5
py-3
hover:bg-blue-50
transition
">


<i class="
fa-solid
fa-paper-plane
text-blue-600
mr-3
"></i>


Disposisi


</a>


<a

href="{{ route('surat.balas',$surat->id) }}"

class="
flex
items-center
px-5
py-3
hover:bg-purple-50
transition
"

>


<i class="
fa-solid
fa-reply
text-purple-600
mr-3
"></i>


Balas Surat


</a>



<a href="#"
class="
flex
items-center
px-5
py-3
hover:bg-green-50
transition
">


<i class="
fa-solid
fa-circle-check
text-green-600
mr-3
"></i>


Approval


</a>



</div>

{{-- END DROPDOWN --}}


</div>

</div>


<script>

function toggleFollow(){

    let menu = document.getElementById('followMenu');


    if(menu){

        menu.classList.toggle('hidden');

    }

}




document.addEventListener('click', function(e){


    let menu = document.getElementById('followMenu');


    let button = e.target.closest('button');



    if(
        menu &&
        !menu.contains(e.target) &&
        !button
    ){

        menu.classList.add('hidden');

    }


});


</script>


</div>


</div>

{{-- ================= PROSES SURAT ================= --}}


<div class="
lg:col-span-2
bg-white
rounded-3xl
shadow-xl
border
border-slate-200
p-8
">


<h2 class="
text-xl
font-black
text-slate-800
flex
items-center
gap-3
mb-8
">


<i class="fa-solid fa-clock-rotate-left text-blue-600"></i>


Proses Surat


</h2>





<div class="relative space-y-8">



{{-- GARIS TIMELINE --}}

<div class="
absolute
left-5
top-3
bottom-3
w-0.5
bg-slate-200
">
</div>






{{-- ================= SURAT DIBUAT ================= --}}


<div class="relative flex gap-5">


<div class="
z-10
w-10
h-10
rounded-full
bg-green-500
text-white
flex
items-center
justify-center
">


<i class="fa-solid fa-check"></i>


</div>



<div>


<h3 class="font-bold text-slate-800">

Surat Dibuat

</h3>


<p class="text-sm text-slate-500">

Oleh {{ $surat->pengirim->name ?? '-' }}

</p>


<p class="text-xs text-slate-400 mt-1">

{{ $surat->created_at?->format('d M Y H:i') }}

</p>


</div>


</div>







{{-- ================= SURAT DIKIRIM ================= --}}


<div class="relative flex gap-5">


<div class="
z-10
w-10
h-10
rounded-full
@if($surat->tanggal_kirim)
bg-green-500 text-white
@else
bg-slate-200 text-slate-500
@endif

flex
items-center
justify-center
">


<i class="fa-solid fa-paper-plane"></i>


</div>



<div>


<h3 class="font-bold text-slate-800">

Surat Dikirim

</h3>



<p class="text-sm text-slate-500">

@if($surat->tanggal_kirim)

Surat berhasil dikirim

@else

Belum dikirim

@endif

</p>



<p class="text-xs text-slate-400 mt-1">


{{ $surat->tanggal_kirim?->format('d M Y H:i') ?? '-' }}


</p>


</div>


</div>







{{-- ================= APPROVAL ================= --}}


<div class="relative flex gap-5">


@if($surat->approval && $surat->approval->count())


<div class="
z-10
w-10
h-10
rounded-full
bg-green-500
text-white
flex
items-center
justify-center
">


<i class="fa-solid fa-check"></i>


</div>



<div>


<h3 class="font-bold text-slate-800">

Approval Selesai

</h3>



@foreach($surat->approval as $approval)


<p class="text-sm text-slate-500">


{{ $approval->approver->name ?? '-' }}


-

{{ $approval->status }}


</p>



@if($approval->approved_at)

<p class="text-xs text-slate-400 mt-1">

{{ $approval->approved_at->format('d M Y H:i') }}

</p>

@endif



@endforeach


</div>




@else



<div class="
z-10
w-10
h-10
rounded-full
bg-yellow-400
text-white
flex
items-center
justify-center
">


<i class="fa-solid fa-hourglass-half"></i>


</div>



<div>


<h3 class="font-bold text-slate-800">

Menunggu Approval

</h3>


<p class="text-sm text-slate-500">

Menunggu persetujuan pejabat terkait

</p>



</div>



@endif



</div>







{{-- ================= PENGESAHAN ================= --}}

<div class="relative flex gap-5">


    <div class="
        z-10
        w-10
        h-10
        rounded-full

        @if($surat->status == 'Disahkan')
            bg-green-500 text-white
        @else
            bg-slate-200 text-slate-500
        @endif

        flex
        items-center
        justify-center
    ">


        <i class="fa-solid fa-signature"></i>


    </div>





    <div class="flex-1">


        <h3 class="font-bold text-slate-800">

            Pengesahan Surat

        </h3>





        @if($surat->status == 'Disahkan')


            <p class="text-sm text-green-600 font-semibold">

                <i class="fa-solid fa-circle-check"></i>

                Surat telah disahkan

            </p>




            @if($surat->pengesahan)


                <div class="
                    mt-3
                    bg-green-50
                    rounded-xl
                    p-4
                    text-sm
                ">


                    <p>

                        Metode :

                        <b>
                            {{ $surat->pengesahan->metode }}
                        </b>

                    </p>




                    <p>

                        Nomor Verifikasi :

                        <b>
                            {{ $surat->pengesahan->nomor_verifikasi }}
                        </b>

                    </p>




                    <p>

                        Tanggal :

                        <b>
                            {{ $surat->pengesahan->tanggal_pengesahan?->format('d M Y H:i') }}
                        </b>

                    </p>




                    @if($surat->pengesahan->qr_code)


                        <a
                        href="{{ asset('storage/'.$surat->pengesahan->qr_code) }}"
                        target="_blank"
                        class="
                        inline-flex
                        mt-3
                        px-4
                        py-2
                        bg-green-600
                        text-white
                        rounded-xl
                        font-bold
                        ">


                            <i class="fa-solid fa-qrcode mr-2"></i>

                            Lihat QR Code


                        </a>


                    @endif



                </div>


            @endif





        @else



            <p class="text-sm text-slate-500">

                Belum dilakukan

            </p>




            <a
            href="{{ route('pengesahan.form',$surat->id) }}"
            class="
            inline-flex
            items-center
            gap-2
            mt-3
            px-5
            py-3
            bg-blue-600
            text-white
            rounded-xl
            font-bold
            hover:bg-blue-700
            ">


                <i class="fa-solid fa-signature"></i>


                Proses Pengesahan


            </a>



        @endif



    </div>



</div>









{{-- ================= SELESAI ================= --}}


<div class="relative flex gap-5">


    <div class="
        z-10
        w-10
        h-10
        rounded-full

        @if($surat->tanggal_selesai)
            bg-green-500 text-white
        @else
            bg-slate-200 text-slate-500
        @endif

        flex
        items-center
        justify-center
    ">


        <i class="fa-solid fa-box-archive"></i>


    </div>





    <div>


        <h3 class="font-bold text-slate-800">

            Selesai

        </h3>





        @if($surat->tanggal_selesai)


            <p class="text-sm text-green-600">

                <i class="fa-solid fa-circle-check"></i>

                Surat selesai diproses

            </p>




            <p class="text-xs text-slate-400 mt-1">

                {{ $surat->tanggal_selesai->format('d M Y H:i') }}

            </p>




        @else



            <p class="text-sm text-slate-500">

                Menunggu penyelesaian surat

            </p>



        @endif



    </div>


</div>









{{-- ================= SURAT BALASAN ================= --}}


@if($surat->balasan->count())


<div class="
bg-white
rounded-3xl
shadow-xl
border
p-8
mb-8
">



<h2 class="
text-xl
font-black
mb-5
">


<i class="
fa-solid
fa-reply
text-purple-600
"></i>


Surat Balasan


</h2>





<div class="space-y-4">



@foreach($surat->balasan as $balasan)



<a

href="{{ route('surat.detail',$balasan->id) }}"

class="
block
border
rounded-xl
p-4
hover:bg-purple-50
transition
"


>


<p class="
font-bold
text-slate-800
">


{{ $balasan->perihal }}


</p>




<p class="
text-sm
text-slate-500
">


{{ $balasan->nomor_surat }}


</p>




<span class="
inline-block
mt-2
px-3
py-1
rounded-full
text-xs
font-bold

@if($balasan->status=='Disahkan')
bg-green-100 text-green-700
@elseif($balasan->status=='Ditolak')
bg-red-100 text-red-700
@else
bg-yellow-100 text-yellow-700
@endif

">


{{ $balasan->status }}


</span>



</a>



@endforeach



</div>


</div>


@endif
{{-- ================= LAMPIRAN + RINGKASAN ================= --}}


<div class="space-y-6">



{{-- ================= LAMPIRAN SURAT ================= --}}


<div class="
bg-white
rounded-3xl
shadow-xl
border
border-slate-200
p-8
">



<div class="
flex
justify-between
items-center
mb-6
">


<h2 class="
text-xl
font-black
text-slate-800
flex
items-center
gap-3
">


<i class="fa-solid fa-paperclip text-blue-600"></i>


Lampiran Surat



<span class="
text-sm
bg-blue-100
text-blue-700
px-3
py-1
rounded-full
">

{{ $surat->lampiran->count() }}

</span>


</h2>





<button

type="button"

onclick="
document.getElementById('modalLampiran').classList.remove('hidden')
"

class="
px-5
py-3
bg-blue-600
text-white
rounded-xl
font-bold
hover:bg-blue-700
transition
">


<i class="fa-solid fa-plus"></i>

Tambah Lampiran


</button>



</div>






{{-- LIST LAMPIRAN --}}


@if($surat->lampiran->count() > 0)



<div class="space-y-4">


@foreach($surat->lampiran as $file)



<div class="
flex
justify-between
items-center
bg-slate-50
rounded-2xl
p-5
border
">



<div class="
flex
items-center
gap-4
">



<div class="
w-12
h-12
rounded-xl
bg-red-100
text-red-600
flex
items-center
justify-center
text-xl
">


@if($file->mime_type == 'application/pdf')

<i class="fa-solid fa-file-pdf"></i>

@else

<i class="fa-solid fa-file"></i>

@endif


</div>





<div>


<p class="font-bold text-slate-800">

{{ $file->nama_file }}

</p>



<p class="text-sm text-slate-500">


@if($file->ukuran_file >= 1048576)

{{ round($file->ukuran_file / 1048576,2) }} MB


@else

{{ round($file->ukuran_file / 1024,2) }} KB


@endif


</p>



<p class="text-xs text-slate-400">

{{ $file->created_at->format('d M Y H:i') }}

</p>



</div>



</div>







<div class="flex gap-3">



<a

href="{{ asset('storage/'.$file->path_file) }}"

target="_blank"

class="
px-5
py-2
bg-blue-600
text-white
rounded-xl
font-bold
hover:bg-blue-700
"

>


<i class="fa-solid fa-eye"></i>

Lihat


</a>



</div>



</div>




@endforeach


</div>



@else



<div class="
text-center
py-10
text-slate-400
">


<i class="
fa-solid
fa-folder-open
text-5xl
mb-4
"></i>



<p>

Belum ada lampiran surat

</p>


</div>



@endif



</div>






{{-- ================= MODAL TAMBAH LAMPIRAN ================= --}}



<div

id="modalLampiran"

class="
hidden
fixed
inset-0
bg-black/50
z-50
flex
items-center
justify-center
"


>


<div class="
bg-white
rounded-3xl
shadow-xl
p-8
w-full
max-w-lg
">





<div class="
flex
justify-between
items-center
mb-6
">


<h2 class="
text-xl
font-black
">

Tambah Lampiran


</h2>



<button

type="button"

onclick="
document.getElementById('modalLampiran').classList.add('hidden')
"

class="
text-slate-500
text-xl
"

>

✕

</button>



</div>







<form

method="POST"

action="{{ route('lampiran.store') }}"

enctype="multipart/form-data"

>


@csrf



<input

type="hidden"

name="surat_id"

value="{{ $surat->id }}"

>





<label class="font-bold">

Pilih File


</label>



<input

type="file"

name="file"

required

class="
mt-3
w-full
border
rounded-xl
p-3
"

>




<button

type="submit"

class="
mt-6
w-full
bg-blue-600
text-white
py-3
rounded-xl
font-bold
hover:bg-blue-700
"

>


<i class="fa-solid fa-upload"></i>


Upload Lampiran


</button>




</form>




</div>


</div>


</div>

{{-- RINGKASAN --}}


<div class="
bg-white
rounded-3xl
shadow-xl
border
border-slate-200
p-6
">


<h2 class="
font-black
text-lg
flex
items-center
gap-3
mb-5
">


<i class="fa-solid fa-chart-simple text-blue-600"></i>


Ringkasan


</h2>





<div class="space-y-4">





<div class="flex justify-between">


<span>

Total Disposisi

</span>


<span class="font-bold">

{{ $surat->disposisi->count() }}

</span>


</div>






<div class="flex justify-between">


<span>

Sudah Dibaca

</span>


<span class="font-bold">

{{ $surat->disposisi->where('dibaca',true)->count() }}

</span>


</div>







<div class="flex justify-between">


<span>

Menunggu Tindak Lanjut

</span>


<span class="font-bold text-yellow-600">

{{ $surat->disposisi->where('status','Menunggu')->count() }}

</span>


</div>






<div class="flex justify-between">


<span>

Selesai

</span>


<span class="font-bold text-green-600">

{{ $surat->disposisi->where('status','Selesai')->count() }}

</span>


</div>




</div>



</div>





</div>




</div>
{{-- ================= DISPOSISI SURAT ================= --}}


<div
class="
mt-8
w-full
bg-white
rounded-3xl
shadow-xl
border
border-slate-200
overflow-hidden
"
>


{{-- HEADER --}}

<div
class="
px-8
py-6
border-b
flex
justify-between
items-center
"
>


<div>

<h2
class="
text-xl
font-black
text-slate-800
flex
items-center
gap-3
"
>

<i class="fa-solid fa-paper-plane text-blue-600"></i>


Disposisi Surat



<span
class="
text-sm
bg-blue-100
text-blue-700
px-3
py-1
rounded-full
"
>

{{ $surat->disposisi->count() }} Penerima

</span>


</h2>


<p class="text-sm text-slate-500 mt-2">

Kelola pengiriman disposisi surat ke unit kerja terkait.

</p>


</div>





<button

type="button"

onclick="openDisposisi()"

class="
bg-blue-600
text-white
px-5
py-3
rounded-xl
font-bold
hover:bg-blue-700
transition
flex
items-center
gap-2
"

>


<i class="fa-solid fa-plus"></i>


Buat Disposisi Baru


</button>



</div>







{{-- TABLE --}}


<div class="overflow-x-auto">


<table
class="
w-full
text-sm
"
>


<thead
class="
bg-slate-50
text-slate-600
"
>


<tr>


<th class="px-6 py-4 text-left">
No
</th>


<th class="px-6 py-4 text-left">
Penerima
</th>


<th class="px-6 py-4 text-left">
Instruksi
</th>


<th class="px-6 py-4 text-left">
Deadline
</th>


<th class="px-6 py-4 text-left">
Status
</th>


<th class="px-6 py-4 text-left">
Tanggal
</th>


<th class="px-6 py-4 text-center">
Aksi
</th>


</tr>


</thead>







<tbody>


@forelse($surat->disposisi as $index=>$item)


<tr
class="
border-t
hover:bg-slate-50
transition
"
>



<td class="px-6 py-5">

{{ $index+1 }}

</td>







<td class="px-6 py-5">


<p class="font-bold text-slate-800">

{{ $item->keUser->name ?? '-' }}

</p>



@if($item->keUser?->jabatan)

<p class="text-xs text-slate-500">

{{ $item->keUser->jabatan->nama_jabatan }}

</p>

@endif


</td>







<td class="px-6 py-5">


<p class="max-w-xs truncate">

{{ $item->instruksi }}

</p>


</td>







<td class="px-6 py-5">


@if($item->deadline)

{{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}

@else

-

@endif


</td>








<td class="px-6 py-5">


@if($item->status == 'Selesai')


<span
class="
px-3
py-2
rounded-full
bg-green-100
text-green-700
font-bold
text-xs
"
>

Selesai

</span>



@elseif($item->status == 'Dalam Proses')


<span
class="
px-3
py-2
rounded-full
bg-blue-100
text-blue-700
font-bold
text-xs
"
>

Dalam Proses

</span>




@elseif($item->status == 'Dibaca')


<span
class="
px-3
py-2
rounded-full
bg-purple-100
text-purple-700
font-bold
text-xs
"
>

Dibaca

</span>




@else


<span
class="
px-3
py-2
rounded-full
bg-yellow-100
text-yellow-700
font-bold
text-xs
"
>

Menunggu

</span>


@endif



</td>








<td class="px-6 py-5">


{{ $item->created_at?->format('d M Y') }}


<br>


<span class="text-xs text-slate-400">

{{ $item->created_at?->format('H:i') }} WIB

</span>


</td>









<td class="px-6 py-5">


<div class="flex justify-center">


<a

href="{{ route('disposisi.show',$item->id) }}"

class="
w-10
h-10
rounded-xl
border
border-blue-500
text-blue-600
flex
items-center
justify-center
hover:bg-blue-50
"

>

<i class="fa-solid fa-eye"></i>

</a>


</div>


</td>



</tr>




@empty


<tr>

<td
colspan="7"
class="
text-center
py-10
text-slate-400
"
>


<i class="
fa-solid
fa-inbox
text-4xl
mb-3
">
</i>


<p>

Belum ada disposisi

</p>


</td>


</tr>


@endforelse


</tbody>



</table>


</div>







<div
class="
px-8
py-4
border-t
text-sm
text-slate-500
"
>


Menampilkan

<b>
{{ $surat->disposisi->count() }}
</b>

data disposisi


</div>



</div>









{{-- ================= MODAL TAMBAH DISPOSISI ================= --}}


<div

id="modalDisposisi"

class="
fixed
inset-0
z-50
hidden
bg-black/50
backdrop-blur-sm
items-center
justify-center
p-6
"

>


<div

class="
bg-white
w-full
max-w-3xl
rounded-3xl
shadow-2xl
p-8
"

>



<div
class="
flex
justify-between
items-center
mb-6
"
>


<h2 class="text-2xl font-black">

Buat Disposisi Baru

</h2>



<button

onclick="closeDisposisi()"

class="
text-2xl
text-slate-500
hover:text-red-500
"

>

×

</button>



</div>





<form

action="{{ route('disposisi.store') }}"

method="POST"

class="space-y-6"

>

@csrf


<input

type="hidden"

name="surat_id"

value="{{ $surat->id }}"

>






<div>

<label class="font-bold">

Penerima

</label>


<select

name="ke_user_id"

class="
mt-2
w-full
rounded-xl
border
px-4
py-3
"

required

>


<option value="">

-- Pilih Penerima --

</option>



@foreach($users as $user)


<option value="{{ $user->id }}">

{{ $user->name }}

</option>


@endforeach



</select>


</div>








<div>


<label class="font-bold">

Instruksi

</label>


<textarea

name="instruksi"

rows="4"

class="
mt-2
w-full
rounded-xl
border
px-4
py-3
"

required

></textarea>


</div>








<div>


<label class="font-bold">

Deadline

</label>


<input

type="date"

name="deadline"

class="
mt-2
w-full
rounded-xl
border
px-4
py-3
"

>


</div>









<div
class="
flex
justify-end
gap-4
"
>


<button

type="button"

onclick="closeDisposisi()"

class="
px-6
py-3
rounded-xl
bg-slate-200
font-bold
"

>

Batal

</button>





<button

type="submit"

class="
px-6
py-3
rounded-xl
bg-blue-600
text-white
font-bold
"

>

Simpan

</button>



</div>



</form>



</div>


</div>









<script>


function openDisposisi(){

let modal = document.getElementById(
'modalDisposisi'
);


modal.classList.remove('hidden');

modal.classList.add(
'flex'
);


}



function closeDisposisi(){


let modal = document.getElementById(
'modalDisposisi'
);


modal.classList.add('hidden');

modal.classList.remove(
'flex'
);


}



</script>
{{-- ================= PENGESAHAN SURAT ================= --}}


<div class="
mt-8
bg-white
rounded-3xl
shadow-xl
border
border-slate-200
overflow-hidden
">





{{-- HEADER --}}


<div class="
px-8
py-6
border-b
">


<h2 class="
text-xl
font-black
text-slate-800
flex
items-center
gap-3
">


<i class="fa-solid fa-signature text-blue-600"></i>


Pengesahan Surat


</h2>



<p class="text-sm text-slate-500 mt-2">


Pilih metode pengesahan surat sesuai kebutuhan.


</p>



</div>







<div class="
p-8
grid
grid-cols-1
lg:grid-cols-2
gap-6
overflow-hidden
">







{{-- ================= TTE ================= --}}



<div class="
border
border-green-300
rounded-3xl
p-6
bg-green-50/40
w-full
min-w-0
">


<div class="
flex
justify-between
items-start
">



<div>


<div class="
flex
items-center
gap-3
">


<i class="
fa-solid
fa-file-signature
text-green-600
text-3xl
"></i>



<h3 class="
text-xl
font-black
text-green-700
">

Tanda Tangan Elektronik (TTE)

</h3>


</div>




<p class="
mt-4
text-sm
text-slate-600
">


Surat akan ditandatangani secara elektronik menggunakan sistem TTE.


</p>



</div>



<i class="
fa-solid
fa-circle-check
text-green-600
text-2xl
"></i>



</div>








<div class="
mt-6
grid
grid-cols-3
gap-3
text-xs
text-slate-600
">



<div class="
bg-white
rounded-xl
p-3
text-center
">


<i class="fa-solid fa-shield-halved text-green-600"></i>


<p class="mt-2">

Aman

</p>


</div>





<div class="
bg-white
rounded-xl
p-3
text-center
">


<i class="fa-solid fa-certificate text-green-600"></i>


<p class="mt-2">

Tersertifikasi

</p>


</div>





<div class="
bg-white
rounded-xl
p-3
text-center
">


<i class="fa-solid fa-lock text-green-600"></i>


<p class="mt-2">

Tidak dapat diubah

</p>


</div>



</div>







<a href="{{ route('pengesahan.tte.form',$surat->id) }}"
class="
inline-flex
items-center
justify-center
px-8
py-3
rounded-xl
bg-blue-600
text-white
font-bold
hover:bg-blue-700
transition
">

<i class="fa-solid fa-signature mr-2"></i>

Gunakan TTE

</a>



</div>













{{-- ================= QR CODE ================= --}}


<div class="
border
border-purple-300
rounded-3xl
p-6
bg-purple-50/40
w-full
min-w-0
">


<div class="
flex
justify-between
items-start
">



<div>


<div class="
flex
items-center
gap-3
">


<i class="
fa-solid
fa-qrcode
text-purple-600
text-3xl
"></i>



<h3 class="
text-xl
font-black
text-purple-700
">

QR Code Verifikasi

</h3>


</div>





<p class="
mt-4
text-sm
text-slate-600
">


Surat diberikan QR Code untuk proses verifikasi dokumen.


</p>



</div>





<i class="
fa-solid
fa-circle-check
text-purple-600
text-2xl
"></i>




</div>









<div class="
mt-6
grid
grid-cols-3
gap-3
text-xs
text-slate-600
">



<div class="
bg-white
rounded-xl
p-3
text-center
">


<i class="fa-solid fa-qrcode text-purple-600"></i>


<p class="mt-2">

Mudah diverifikasi

</p>


</div>






<div class="
bg-white
rounded-xl
p-3
text-center
">


<i class="fa-solid fa-bolt text-purple-600"></i>


<p class="mt-2">

Cepat

</p>


</div>






<div class="
bg-white
rounded-xl
p-3
text-center
">


<i class="fa-solid fa-mobile-screen text-purple-600"></i>


<p class="mt-2">

Praktis

</p>


</div>




</div>




<a href="{{ route('pengesahan.qr.form',$surat->id) }}"
class="
inline-flex
items-center
justify-center
px-8
py-3
rounded-xl
bg-purple-600
text-white
font-bold
hover:bg-purple-700
transition
">

<i class="fa-solid fa-qrcode mr-2"></i>

Gunakan QR Code

</a>
</div>




<hr class="my-6">


<h3 class="
font-black
text-lg
mb-4
">

Upload Pengesahan Manual

</h3>



<form

method="POST"

action="{{ route('pengesahan.upload',$surat->id) }}"

enctype="multipart/form-data"

>

@csrf



<select

name="metode"

class="
w-full
border
rounded-xl
p-3
mb-4
"

>


<option value="TTE">

Upload TTE

</option>


<option value="QR Code">

Upload QR Code

</option>


</select>





<input

type="file"

name="file"

required

class="
w-full
border
rounded-xl
p-3
mb-4
"

>




<button

class="
w-full
bg-slate-800
text-white
py-3
rounded-xl
font-bold
"

>

<i class="fa-solid fa-upload"></i>

Upload Pengesahan

</button>



</form>



</div>









{{-- INFORMASI --}}


<div class="
mx-8
mb-8
bg-blue-50
border
border-blue-200
rounded-2xl
p-5
flex
gap-4
">


<i class="
fa-solid
fa-circle-info
text-blue-600
text-xl
"></i>


<div>


<p class="font-bold text-slate-800">

Informasi

</p>



<p class="text-sm text-slate-600">


Setelah pengesahan dilakukan, surat menjadi dokumen resmi dan tidak dapat diubah kembali.


</p>



</div>



</div>




{{-- MODAL TAMBAH LAMPIRAN --}}


<div

id="modalLampiran"

class="
hidden
fixed
inset-0
bg-black/40
z-50
flex
items-center
justify-center
">


<div class="
bg-white
rounded-3xl
p-8
w-full
max-w-lg
">


<h2 class="
text-xl
font-black
mb-5
">

Tambah Lampiran Surat

</h2>



<form

action="{{ route('lampiran.store') }}"

method="POST"

enctype="multipart/form-data"

>


@csrf


<input

type="hidden"

name="surat_id"

value="{{ $surat->id }}"
>



<label class="font-bold">

Pilih File

</label>


<input

type="file"

name="file"

required

class="
mt-3
w-full
border
rounded-xl
p-3
"

>



<div class="
flex
gap-3
mt-6
">


<button

type="button"

onclick="
document.getElementById('modalLampiran').classList.add('hidden')
"

class="
px-5
py-3
bg-slate-200
rounded-xl
font-bold
">

Batal


</button>



<button

class="
px-5
py-3
bg-blue-600
text-white
rounded-xl
font-bold
">

Upload


</button>



</div>



</form>



</div>


</div>

</div>
{{-- MODAL DISPOSISI --}}

<div

id="modalDisposisi"

class="
hidden
fixed
inset-0
bg-black/50
z-50
items-center
justify-center
p-5
">

<div class="
bg-white
rounded-3xl
p-8
w-full
max-w-xl
max-h-[90vh]
overflow-y-auto
shadow-2xl
">


<h2 class="
text-xl
font-black
mb-6
">

Buat Disposisi Baru

</h2>

<button

type="button"

onclick="
document.getElementById('modalDisposisi').classList.add('hidden')
"

class="
absolute
right-6
top-6
text-slate-400
hover:text-red-500
"

>

<i class="fa-solid fa-xmark text-xl"></i>

</button>



<form

method="POST"

action="{{ route('disposisi.store') }}"

>

@csrf


<input

type="hidden"

name="surat_id"

value="{{ $surat->id }}"

>





<label class="font-bold">

Penerima

</label>


<select

name="ke_user_id[]"

multiple

required

class="
w-full
h-32
border
border-slate-300
rounded-xl
p-3
mt-2
mb-5
focus:ring-2
focus:ring-blue-500
"
>


@foreach($users as $user)


<option value="{{ $user->id }}">

{{ $user->name }}

-
{{ $user->jabatan->nama_jabatan ?? '-' }}


</option>


@endforeach


</select>





<label class="font-bold">

Instruksi

</label>


<textarea

name="instruksi"

required

class="
w-full
border
rounded-xl
p-3
mt-2
mb-5
"

rows="4"

></textarea>





<label class="font-bold">

Deadline

</label>


<input

type="date"

name="deadline"

class="
w-full
border
rounded-xl
p-3
mt-2
mb-6
"


>






<button

class="
bg-blue-600
text-white
px-6
py-3
rounded-xl
font-bold
w-full
"

>

Kirim Disposisi

</button>



</form>



</div>


</div>
<script>

function toggleFollow(){

document
.getElementById('followMenu')
.classList.toggle('hidden');

}

</script>

@endsection