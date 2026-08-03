@extends('layouts.app')

@section('title','Detail Surat')

@section('content')
<div class="w-full px-6 py-8">

<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- ==========================================================
    DETAIL INFORMASI SURAT
========================================================== --}}


<div class="
relative
bg-white
rounded-3xl
shadow-2xl
border
border-slate-200
overflow-hidden
">


{{-- ================= CLOSE BUTTON ================= --}}

<a href="{{ route('surat.inbox') }}"

class="
absolute
right-7
top-7
z-20
w-12
h-12
rounded-full
bg-white
border
border-slate-200
text-slate-500
flex
items-center
justify-center
shadow-lg
hover:bg-blue-600
hover:text-white
hover:rotate-90
transition
duration-300
">

<i class="fa-solid fa-xmark text-xl"></i>

</a>




{{-- ================= HEADER ================= --}}


<div class="
px-10
py-10
bg-gradient-to-br
from-blue-50
via-white
to-blue-100
border-b
border-slate-200
">


<div class="
flex
justify-between
items-start
gap-5
pr-16
">


<div>


<div class="
flex
items-center
gap-3
mb-3
">


<div class="
w-12
h-12
rounded-2xl
bg-blue-600
text-white
flex
items-center
justify-center
shadow-lg
">

<i class="fa-solid fa-envelope-open-text text-xl"></i>

</div>


<h1 class="
text-3xl
font-black
text-slate-800
">

{{ $surat->perihal }}

</h1>


</div>




<div class="
flex
items-center
gap-2
text-slate-500
">

<i class="
fa-solid
fa-hashtag
text-blue-600
"></i>


Nomor Surat :

<span class="
font-bold
text-slate-800
">

{{ $surat->nomor_surat }}

</span>


</div>




@if($surat->parent_surat_id)


<div class="
mt-6
bg-blue-100/70
border
border-blue-200
rounded-2xl
p-5
">


<div class="
flex
items-center
gap-2
text-blue-700
font-bold
">

<i class="
fa-solid
fa-reply
"></i>

Surat Balasan

</div>



<p class="
mt-3
font-bold
text-slate-800
">

Nomor :

{{ $surat->suratInduk->nomor_surat ?? '-' }}

</p>



<p class="
text-sm
text-slate-500
mt-1
">

{{ $surat->suratInduk->perihal ?? '-' }}

</p>


</div>


@endif



</div>





{{-- STATUS --}}

<span class="
inline-flex
items-center
gap-2
px-5
py-3
rounded-full
font-bold
shadow-sm

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

<i class="fa-solid fa-circle-check"></i>

@elseif($surat->status == 'Ditolak')

<i class="fa-solid fa-circle-xmark"></i>

@endif


{{ $surat->status }}

</span>


</div>


</div>





{{-- ================= DETAIL GRID ================= --}}


<div class="
p-10
grid
md:grid-cols-3
gap-6
">



{{-- ================= JENIS SURAT ================= --}}

<div class="
bg-slate-50
rounded-2xl
p-5
hover:shadow-md
transition
">


<div class="
flex
items-center
gap-3
mb-3
">


<div class="
w-10
h-10
rounded-xl
bg-blue-100
text-blue-600
flex
items-center
justify-center
">

<i class="fa-solid fa-file-lines"></i>

</div>


<p class="
text-sm
text-slate-400
">

Jenis Surat

</p>


</div>



<p class="
font-black
text-lg
text-slate-800
">

{{ $surat->jenisSurat->nama_jenis ?? '-' }}

</p>


</div>





{{-- ================= TANGGAL SURAT ================= --}}

<div class="
bg-slate-50
rounded-2xl
p-5
hover:shadow-md
transition
">


<div class="
flex
items-center
gap-3
mb-3
">


<div class="
w-10
h-10
rounded-xl
bg-green-100
text-green-600
flex
items-center
justify-center
">

<i class="fa-solid fa-calendar"></i>

</div>


<p class="
text-sm
text-slate-400
">

Tanggal Surat

</p>


</div>



<p class="
font-black
text-lg
text-slate-800
">

{{ $surat->tanggal_surat?->format('d M Y') }}

</p>


</div>





{{-- ================= SIFAT SURAT ================= --}}

<div class="
bg-slate-50
rounded-2xl
p-5
hover:shadow-md
transition
">


<div class="
flex
items-center
gap-3
mb-3
">


<div class="
w-10
h-10
rounded-xl
bg-purple-100
text-purple-600
flex
items-center
justify-center
">

<i class="fa-solid fa-star"></i>

</div>


<p class="
text-sm
text-slate-400
">

Sifat Surat

</p>


</div>



<p class="
font-black
text-lg
text-slate-800
">

{{ $surat->sifatSurat->nama_sifat ?? '-' }}

</p>


</div></div>



{{-- ==================================================
    DEADLINE + PENGIRIM + TUJUAN
================================================== --}}



@php

$deadlineSurat = $surat->deadline
    ? \Carbon\Carbon::parse($surat->deadline)
        ->timezone('Asia/Makassar')
    : null;


$now = now()
    ->timezone('Asia/Makassar');


$selisihDeadline = $deadlineSurat
    ? $now->diffInHours($deadlineSurat,false)
    : null;


@endphp





<div class="
px-10
pb-10

grid
md:grid-cols-3

gap-6
">





{{-- ================= DEADLINE ================= --}}


<div class="
rounded-2xl
p-5
hover:shadow-md
transition


@if($selisihDeadline === null)

bg-slate-50

@elseif($selisihDeadline < 0)

bg-red-50

@elseif($selisihDeadline <=24)

bg-yellow-50

@else

bg-green-50

@endif

">


<div class="
flex
items-center
gap-3
mb-3
">


<div class="
w-10
h-10
rounded-xl
flex
items-center
justify-center


@if($selisihDeadline === null)

bg-slate-100 text-slate-500


@elseif($selisihDeadline <0)

bg-red-100 text-red-600


@elseif($selisihDeadline <=24)

bg-yellow-100 text-yellow-600


@else

bg-green-100 text-green-600


@endif

">


<i class="fa-solid fa-clock"></i>


</div>


<p class="
text-sm
text-slate-400
">

Deadline

</p>


</div>




<p class="
font-black
text-lg


@if($selisihDeadline <0)

text-red-600


@elseif($selisihDeadline <=24)

text-yellow-600


@else

text-green-600


@endif

">


@if($deadlineSurat)

{{ $deadlineSurat->translatedFormat('d M Y H:i') }}




@else

-

@endif


</p>





<p class="
text-sm
font-bold
mt-2
">


@if($selisihDeadline === null)


Belum ditentukan



@elseif($selisihDeadline <0)


<i class="fa-solid fa-circle-xmark text-red-600"></i>

Deadline Terlewat



@elseif($selisihDeadline <=24)


<i class="fa-solid fa-clock text-yellow-600"></i>

Segera



@else


<i class="fa-solid fa-circle-check text-green-600"></i>

Masih Aman



@endif


</p>


</div>







{{-- ================= PENGIRIM ================= --}}


<div class="
bg-slate-50
rounded-2xl
p-5
hover:shadow-md
transition
">


<div class="
flex
items-center
gap-3
mb-3
">


<div class="
w-10
h-10
rounded-xl
bg-blue-100
text-blue-600
flex
items-center
justify-center
">


<i class="fa-solid fa-user"></i>


</div>



<p class="
text-sm
text-slate-400
">

Pengirim

</p>


</div>




<p class="
font-black
text-lg
text-slate-800
">

{{ $surat->pengirim->name ?? '-' }}

</p>



<p class="
text-sm
text-slate-500
">

{{ $surat->pengirim->jabatan->nama_jabatan ?? '-' }}

</p>


</div>








{{-- ================= TUJUAN ================= --}}


<div class="
bg-slate-50
rounded-2xl
p-5
hover:shadow-md
transition
">


<div class="
flex
items-center
gap-3
mb-3
">


<div class="
w-10
h-10
rounded-xl
bg-cyan-100
text-cyan-600
flex
items-center
justify-center
">


<i class="fa-solid fa-users"></i>


</div>



<p class="
text-sm
text-slate-400
">

Tujuan

</p>


</div>





@forelse($surat->tujuan as $tujuan)


<p class="
font-black
text-lg
text-slate-800
">

{{ $tujuan->user->name ?? '-' }}

</p>



<p class="
text-sm
text-slate-500
mb-2
">

{{ $tujuan->user->jabatan->nama_jabatan ?? '-' }}

</p>



@empty


<p class="
font-black
text-slate-800
">

-

</p>


@endforelse



</div>





</div>@php

// ================= STATUS APPROVAL =================


$approvalSelesai = false;


if(
    $surat->approval &&
    $surat->approval->count()
){

    $approvalSelesai =
        $surat->approval
        ->every(
            fn($item)=>
            $item->status == 'Disetujui'
        );

}




// ================= STATUS PENGESAHAN =================


$pengesahanStatus = false;


if(
    $surat->pengesahan ||
    $surat->status == 'Disahkan'
){

    $pengesahanStatus = true;

}




// ================= STATUS SELESAI =================


$selesaiStatus = false;


if($surat->tanggal_selesai){

    $selesaiStatus = true;

}


@endphp




</div>
</div>
{{-- ==========================================================
    PROSES SURAT
========================================================== --}}

<div class="
bg-white
rounded-3xl
shadow-xl
border
border-slate-200
p-8
mb-8
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


<i class="
fa-solid
fa-clock-rotate-left
text-blue-600
">
</i>


Proses Surat


</h2>





{{-- TIMELINE --}}

<div class="relative space-y-8">


{{-- GARIS TIMELINE --}}

<div class="
absolute
left-5
top-3
h-[calc(100%-24px)]
w-0.5
bg-slate-200
">
</div>





{{-- ======================================================
    SURAT DIBUAT
====================================================== --}}

<div class="
relative
flex
gap-5
">


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


<h3 class="
font-bold
text-slate-800
">

Surat Dibuat

</h3>



<p class="
text-sm
text-slate-500
">

Oleh {{ $surat->pengirim->name ?? '-' }}

</p>



<p class="
text-xs
text-slate-400
mt-1
">

{{ 
$surat->created_at
?->timezone('Asia/Makassar')
->translatedFormat('d M Y H:i')
}}

</p>



</div>


</div>







{{-- ======================================================
    SURAT DIKIRIM
====================================================== --}}


<div class="
relative
flex
gap-5
">


<div class="
z-10
w-10
h-10
rounded-full

@if($surat->tanggal_kirim)

bg-green-500
text-white

@else

bg-slate-200
text-slate-500

@endif

flex
items-center
justify-center
">


<i class="fa-solid fa-paper-plane"></i>


</div>




<div>


<h3 class="
font-bold
text-slate-800
">

Surat Dikirim

</h3>



<p class="
text-sm
text-slate-500
">


@if($surat->tanggal_kirim)

Surat berhasil dikirim


@else

Belum dikirim


@endif


</p>



<p class="
text-xs
text-slate-400
mt-1
">
{{
$surat->tanggal_kirim
?->timezone('Asia/Makassar')
->translatedFormat('d M Y H:i')
?? '-'
}}

</p>



</div>


</div>

{{-- ======================================================
    APPROVAL
====================================================== --}}

<div class="relative flex gap-5">


@php

$approvalSelesai =
$surat->approval &&
$surat->approval->count() &&
$surat->approval->every(
    fn($item)=>$item->status == 'Disetujui'
);

@endphp



<div class="
z-10
w-10
h-10
rounded-full

@if($approvalSelesai)

bg-green-500
text-white

@else

bg-yellow-400
text-white

@endif

flex
items-center
justify-center
">


@if($approvalSelesai)

<i class="fa-solid fa-check"></i>

@else

<i class="fa-solid fa-hourglass-half"></i>

@endif


</div>




<div>


<h3 class="
font-bold
text-slate-800
">

Approval

</h3>



@if($approvalSelesai)


<p class="
text-sm
text-green-600
font-semibold
">

Approval telah disetujui

</p>



@foreach($surat->approval as $approval)

<p class="
text-sm
text-slate-500
">

{{ $approval->approver->name ?? '-' }}

-

{{ $approval->status }}

</p>


@endforeach




@else


<p class="
text-sm
text-yellow-600
">

Menunggu persetujuan pejabat terkait

</p>



@foreach($surat->approval as $approval)

<p class="
text-xs
text-slate-500
">

{{ $approval->approver->name ?? '-' }}

:

{{ $approval->status }}

</p>


@endforeach


@endif



</div>


</div>

{{-- ======================================================
    DISPOSISI
====================================================== --}}

@if($surat->disposisi && $surat->disposisi->count())


<div class="
relative
flex
gap-5
">


@php

$totalDisposisi = $surat->disposisi->count();

$selesaiDisposisi = 
$surat->disposisi
->where('status','Selesai')
->count();


$disposisiSelesai =
$totalDisposisi == $selesaiDisposisi;


@endphp




<div class="
z-10
w-10
h-10
rounded-full

@if($disposisiSelesai)

bg-green-500
text-white

@else

bg-yellow-400
text-white

@endif

flex
items-center
justify-center
">


@if($disposisiSelesai)

<i class="fa-solid fa-check"></i>

@else

<i class="fa-solid fa-paper-plane"></i>

@endif


</div>





<div>


<h3 class="
font-bold
text-slate-800
">

Disposisi Surat

</h3>



@if($disposisiSelesai)


<p class="
text-sm
text-green-600
font-semibold
">

Semua disposisi telah selesai

</p>


@else


<p class="
text-sm
text-yellow-600
">

Menunggu tindak lanjut penerima disposisi

</p>


@endif




<p class="
text-xs
text-slate-500
mt-1
">

{{ $selesaiDisposisi }}/{{ $totalDisposisi }}

disposisi selesai

</p>



</div>



</div>


@endif

{{-- ======================================================
    PENGESAHAN
====================================================== --}}


<div class="
relative
flex
gap-5
">


<div class="
z-10
w-10
h-10
rounded-full

@if($pengesahanStatus)

bg-green-500
text-white

@else

bg-slate-200
text-slate-500

@endif

flex
items-center
justify-center
">


<i class="fa-solid fa-signature"></i>


</div>





<div class="flex-1">


<h3 class="
font-bold
text-slate-800
">

Pengesahan Surat

</h3>




@if($surat->status == 'Disahkan')


<p class="
text-sm
text-green-600
font-semibold
">

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

{{
$surat->pengesahan->tanggal_pengesahan
?->timezone('Asia/Makassar')
->translatedFormat('d M Y H:i')
}}
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


<i class="
fa-solid
fa-qrcode
mr-2
">
</i>


Lihat QR Code


</a>


@endif


</div>


@endif





@else



<p class="
text-sm
text-slate-500
">

Belum dilakukan

</p>




@endif



</div>



</div>







{{-- ======================================================
    SELESAI
====================================================== --}}


<div class="
relative
flex
gap-5
">


<div class="
z-10
w-10
h-10
rounded-full

@if($surat->tanggal_selesai)

bg-green-500
text-white

@else

bg-slate-200
text-slate-500

@endif

flex
items-center
justify-center
">


<i class="fa-solid fa-box-archive"></i>


</div>





<div>


<h3 class="
font-bold
text-slate-800
">

Selesai

</h3>




@if($surat->tanggal_selesai)


<p class="
text-sm
text-green-600
">


<i class="fa-solid fa-circle-check"></i>


Surat selesai diproses


</p>




<p class="
text-xs
text-slate-400
mt-1
">
{{
$surat->tanggal_selesai
->timezone('Asia/Makassar')
->translatedFormat('d M Y H:i')
}}

</p>




@else



<p class="
text-sm
text-slate-500
">

Menunggu penyelesaian surat

</p>



@endif



</div>


</div>


</div>


</div>
{{-- ==========================================================
    RIWAYAT BALASAN SURAT
========================================================== --}}


<div class="
bg-white
rounded-3xl
shadow-xl
border
border-slate-200
p-8
mb-8
">


{{-- HEADER --}}

<div class="
flex
justify-between
items-center
mb-8
">


<div>

<h2 class="
text-xl
font-black
text-slate-800
flex
items-center
gap-3
">


<i class="
fa-solid
fa-reply
text-blue-600
"></i>


Riwayat Balasan Surat


</h2>



<p class="
text-sm
text-slate-500
mt-2
">

Daftar surat balasan yang berkaitan dengan surat ini.

</p>


</div>





<button

type="button"

onclick="openBalas()"

class="
px-5
py-3
bg-blue-600
text-white
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


Buat Balasan Baru


</button>



</div>









{{-- LIST BALASAN --}}


<div class="space-y-5">



@forelse($riwayatBalasan as $balasan)



<div

class="
border
border-slate-200
rounded-2xl
p-6
bg-slate-50
hover:bg-blue-50
transition
flex
justify-between
gap-6
"

>





{{-- DETAIL BALASAN --}}


<div class="flex-1">



<h3

class="
text-lg
font-black
text-slate-800
"

>

{{ $balasan->perihal }}


</h3>





<div

class="
mt-3
space-y-2
text-sm
text-slate-600
"

>





<p>

<i class="
fa-solid
fa-user
text-blue-500
mr-2
"></i>


Dari :

<b>

{{ $balasan->pengirim->name ?? '-' }}

</b>


</p>





<p>

<i class="
fa-solid
fa-paper-plane
text-blue-500
mr-2
"></i>


Kepada :

<b>

{{ $balasan->tujuan->first()->user->name ?? '-' }}

</b>


</p>





<p>

<i class="
fa-solid
fa-calendar
text-blue-500
mr-2
"></i>


Tanggal :
{{
$balasan->tanggal_surat
?->timezone('Asia/Makassar')
->translatedFormat('d M Y H:i')
??
$balasan->created_at
->timezone('Asia/Makassar')
->translatedFormat('d M Y H:i')
}}


</p>


</div>








<div

class="
mt-4
bg-white
border
rounded-xl
p-4
"

>


<p

class="
text-xs
text-slate-500
mb-2
"

>

Isi Balasan

</p>



<p class="
text-sm
text-slate-700
">

{{ Str::limit($balasan->catatan,120) }}


</p>


</div>




</div>









{{-- STATUS --}}


<div

class="
flex
flex-col
items-end
gap-3
"

>



@if($balasan->status == 'Draft')



<span

class="
px-4
py-2
rounded-full
text-xs
font-bold
bg-slate-200
text-slate-700
flex
items-center
gap-2
"

>


<i class="fa-solid fa-file"></i>


Draft


</span>





<div class="flex gap-2">


<a

href="{{ route('surat.edit',$balasan->id) }}"

class="
w-10
h-10
rounded-xl
bg-white
border
flex
items-center
justify-center
text-blue-600
hover:bg-blue-50
"

>


<i class="fa-solid fa-pen"></i>


</a>






<form

action="{{ route('surat.destroy',$balasan->id) }}"

method="POST"

>


@csrf

@method('DELETE')



<button

onclick="return confirm('Hapus draft balasan?')"

class="
w-10
h-10
rounded-xl
bg-red-50
text-red-600
flex
items-center
justify-center
hover:bg-red-100
"

>


<i class="fa-solid fa-trash"></i>


</button>


</form>


</div>




@else



<span

class="
px-4
py-2
rounded-full
text-xs
font-bold
bg-green-100
text-green-700
flex
items-center
gap-2
"

>


<i class="fa-solid fa-check"></i>


Terkirim


</span>



@endif



</div>






</div>




@empty



<div

class="
text-center
py-10
text-slate-400
"

>


<i class="
fa-solid
fa-inbox
text-5xl
mb-4
"></i>


<p>

Belum ada riwayat balasan surat

</p>


</div>



@endforelse




</div>


</div>






{{-- ==========================================================
    MODAL BALAS SURAT
========================================================== --}}


<div

id="modalBalas"

class="
hidden
fixed
inset-0
z-[9999]
bg-black/50
backdrop-blur-sm
items-center
justify-center
p-5
"

>


<div

class="
bg-white
rounded-3xl
shadow-2xl
w-full
max-w-3xl
overflow-hidden
"

>



{{-- HEADER MODAL --}}


<div

class="
bg-gradient-to-r
from-blue-600
to-cyan-500
p-6
text-white
"

>


<div

class="
flex
justify-between
items-center
"

>


<div>


<h2

class="
text-2xl
font-black
flex
items-center
gap-3
"

>


<i class="fa-solid fa-reply"></i>


Balas Surat


</h2>



<p class="
text-sm
opacity-90
"

>

Buat surat balasan dari surat yang diterima

</p>


</div>





<button

onclick="closeBalas()"

class="
w-10
h-10
rounded-full
bg-white/20
hover:bg-white/30
flex
items-center
justify-center
"

>


<i class="
fa-solid
fa-xmark
text-xl
"></i>


</button>


</div>


</div>








<form

method="POST"

action="{{ route('surat.balas.store',$surat->id) }}"

class="
p-8
space-y-5
"

>


@csrf




<div>


<label class="font-bold">

Tujuan Surat

</label>



<div

class="
mt-2
bg-blue-50
border
border-blue-200
rounded-xl
p-4
flex
justify-between
items-center
"

>


<div>


<p class="font-bold">

{{ $surat->pengirim->name ?? '-' }}

</p>


<p class="text-sm text-slate-500">

Penerima otomatis

</p>


</div>



<span

class="
bg-blue-100
text-blue-700
px-3
py-1
rounded-full
text-xs
font-bold
"

>

Otomatis

</span>


</div>



<input

type="hidden"

name="tujuan_id"

value="{{ $surat->pengirim_id }}"

>


</div>







<div>


<label class="font-bold">

Perihal

</label>



<input

name="perihal"

value="Balasan {{ $surat->perihal }}"

class="
mt-2
w-full
border
rounded-xl
p-3
"

required

>


</div>







<div>


<label class="font-bold">

Isi Balasan

</label>



<textarea

name="catatan"

rows="6"

required

class="
mt-2
w-full
border
rounded-xl
p-4
"

placeholder="Tuliskan isi balasan surat..."

></textarea>



</div>






<div

class="
flex
justify-end
gap-3
pt-5
border-t
"

>








<button

type="submit"

class="
px-6
py-3
rounded-xl
bg-blue-600
text-white
font-bold
hover:bg-blue-700
flex
items-center
gap-2
"

>


<i class="fa-solid fa-paper-plane"></i>


Kirim Balasan


</button>


</div>



</form>



</div>


</div>







<script>


function openBalas(){


let modal = document.getElementById('modalBalas');


modal.classList.remove('hidden');

modal.classList.add('flex');


document.body.style.overflow='hidden';


}





function closeBalas(){


let modal = document.getElementById('modalBalas');


modal.classList.add('hidden');

modal.classList.remove('flex');


document.body.style.overflow='auto';


}



</script>

{{-- ==========================================================
    LAMPIRAN SURAT
========================================================== --}}



<div class="
bg-white
rounded-3xl
shadow-xl
border
border-slate-200
p-8
mb-8
">





{{-- HEADER --}}


<div class="
flex
justify-between
items-center
mb-6
">


<div class="
flex
items-center
gap-3
">


<h2 class="
text-xl
font-black
text-slate-800
flex
items-center
gap-3
">


<i class="
fa-solid
fa-paperclip
text-blue-600
"></i>


Lampiran Surat


</h2>




<span class="
px-3
py-1
rounded-full
bg-blue-100
text-blue-700
text-sm
font-bold
">


{{ $surat->lampiran->count() }}


</span>



</div>






<div class="flex gap-3">






<button

type="button"

onclick="
document
.getElementById('modalLampiran')
.classList.remove('hidden')
"

class="
px-5
py-3
rounded-xl
bg-blue-600
text-white
font-bold
hover:bg-blue-700
transition
flex
items-center
gap-2
">


<i class="fa-solid fa-plus"></i>


Tambah Lampiran


</button>



</div>


</div>







{{-- DATA LAMPIRAN --}}


@if($surat->lampiran->count())


<div class="space-y-4">


@foreach($surat->lampiran->sortByDesc('created_at') as $file)



<div class="
flex
justify-between
items-center
bg-slate-50
border
border-slate-200
rounded-2xl
p-5
hover:bg-blue-50
transition
">





<div class="
flex
items-center
gap-5
">



<div class="
w-14
h-14
rounded-xl
bg-blue-100
flex
items-center
justify-center
text-2xl
">


@if(str_contains($file->mime_type,'pdf'))

<i class="
fa-solid
fa-file-pdf
text-red-600
"></i>


@elseif(str_contains($file->mime_type,'image'))


<i class="
fa-solid
fa-image
text-purple-600
"></i>


@else


<i class="
fa-solid
fa-file
text-slate-600
"></i>


@endif


</div>





<div>


<h3 class="
font-black
text-slate-800
">

{{ $file->nama_file }}


</h3>



<p class="
text-sm
text-slate-500
mt-1
">


@if($file->ukuran_file >= 1048576)

{{ number_format($file->ukuran_file / 1048576,2) }} MB


@else


{{ number_format($file->ukuran_file / 1024,2) }} KB


@endif


•
{{ 
$file->created_at
->timezone('Asia/Makassar')
->translatedFormat('d M Y H:i')
}}


</p>




<p class="
text-sm
text-slate-600
">


Diunggah oleh:

<b>

{{ $file->uploadedBy->name ?? 'Tidak diketahui' }}

</b>


</p>



</div>


</div>






<a href="{{ route('lampiran.view',$file->id) }}"

target="_blank"

class="
w-12
h-12
rounded-full
bg-blue-100
text-blue-600
flex
items-center
justify-center
hover:bg-blue-600
hover:text-white
transition
">


<i class="fa-solid fa-eye"></i>


</a>



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
{{-- ==========================================================
    DISPOSISI SURAT
========================================================== --}}

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
flex
justify-between
items-center
">


<div>


<h2 class="
text-xl
font-black
text-slate-800
flex
items-center
gap-3
">


<i class="
fa-solid fa-paper-plane
text-blue-600
"></i>


Disposisi Surat



<span class="
text-sm
bg-blue-100
text-blue-700
px-3
py-1
rounded-full
">

{{ $surat->disposisi->count() }} Penerima

</span>


</h2>



<p class="
text-sm
text-slate-500
mt-2
">

Daftar penerima disposisi surat.

</p>


</div>





<button

type="button"

onclick="openDisposisi()"

class="
px-5
py-3
bg-blue-600
text-white
rounded-xl
font-bold
hover:bg-blue-700
transition
flex
items-center
gap-2
">

<i class="
fa-solid fa-plus
"></i>


Buat Disposisi Baru


</button>



</div>






{{-- TABLE --}}


<div class="overflow-x-auto">


<table class="w-full text-sm">


<thead class="
bg-slate-50
">


<tr>


<th class="
px-6
py-4
text-left
">

No

</th>


<th class="
px-6
py-4
text-left
">

Penerima

</th>


<th class="
px-6
py-4
text-left
">

Status

</th>


<th class="
px-6
py-4
text-center
">

Aksi

</th>


</tr>


</thead>






<tbody>


@forelse($surat->disposisi as $index=>$item)



<tr class="
border-t
hover:bg-slate-50
transition
">


<td class="
px-6
py-5
">

{{ $index+1 }}

</td>






<td class="
px-6
py-5
">


<p class="
font-bold
text-slate-800
">

{{ $item->keUser->name ?? '-' }}

</p>



<p class="
text-xs
text-slate-500
">

{{ $item->keUser->jabatan->nama_jabatan ?? '-' }}

</p>


</td>




<td class="px-6 py-5">


@if($item->status == 'Selesai')


<span class="
inline-flex
items-center
gap-2
px-4
py-2
rounded-full
bg-green-100
text-green-700
font-bold
text-xs
">

<i class="fa-solid fa-check"></i>

Selesai

</span>




@elseif($item->status == 'Telah Dibaca')


<span class="
inline-flex
items-center
gap-2
px-4
py-2
rounded-full
bg-blue-100
text-blue-700
font-bold
text-xs
">

<i class="fa-solid fa-eye"></i>

Telah Dibaca

</span>





@else


<span class="
inline-flex
items-center
gap-2
px-4
py-2
rounded-full
bg-yellow-100
text-yellow-700
font-bold
text-xs
">

<i class="fa-solid fa-clock"></i>

Menunggu

</span>



@endif


</td>







<td class="
px-6
py-5
text-center
">



<button

type="button"

onclick="openDisposisiDetail(this)"


data-id="{{ $item->id }}"

data-nomor="{{ $item->surat->nomor_surat ?? '-' }}"

data-perihal="{{ $item->surat->perihal ?? '-' }}"

data-dari="{{ $item->dariUser->name ?? '-' }}"

data-kepada="{{ $item->keUser->name ?? '-' }}"

data-instruksi="{{ $item->instruksi ?? '-' }}"
data-deadline="{{ 
$item->deadline 
? \Carbon\Carbon::parse($item->deadline)
->timezone('Asia/Makassar')
->format('Y-m-d H:i:s')
: '-' 
}}"
data-status="{{ $item->status }}"



class="
w-10
h-10
rounded-xl
bg-blue-50
text-blue-600
hover:bg-blue-600
hover:text-white
transition
inline-flex
items-center
justify-center
"


title="Detail Disposisi"

>


<i class="
fa-solid fa-eye
"></i>


</button>



</td>



</tr>



@empty


<tr>


<td colspan="4"

class="
text-center
py-10
text-slate-400
">


<i class="
fa-solid fa-inbox
text-4xl
mb-3
"></i>


<p>

Belum ada disposisi

</p>


</td>


</tr>



@endforelse



</tbody>



</table>


</div>



</div>
{{-- ======================================================
    MODAL DETAIL DISPOSISI
====================================================== --}}


<div

id="modalDisposisiDetail"

class="
hidden
fixed
inset-0
z-[9999]

bg-black/50
backdrop-blur-md

items-center
justify-center

p-5

"

>


<div class="
bg-white
w-full
max-w-xl
rounded-3xl
shadow-2xl
overflow-hidden
">



{{-- HEADER MODAL --}}


<div class="
bg-gradient-to-r
from-blue-600
to-cyan-500

p-6

text-white
">


<div class="
flex
justify-between
items-center
">


<div>


<h2 class="
text-2xl
font-black
flex
items-center
gap-3
">


<i class="
fa-solid fa-share-from-square
"></i>


Detail Disposisi


</h2>



<p class="
text-sm
opacity-90
mt-1
">

Informasi penerusan surat

</p>


</div>





<button

type="button"

onclick="closeDisposisiDetail()"

class="
w-10
h-10

rounded-full

bg-white/20

hover:bg-white/40

transition

flex
items-center
justify-center

text-xl

">


<i class="
fa-solid fa-xmark
"></i>


</button>



</div>


</div>









{{-- BODY --}}



<div class="
p-8
space-y-6
">





<input

type="hidden"

id="detailDisposisiId"

>






<div>


<p class="
text-sm
text-slate-400
">

Nomor Surat

</p>



<p

id="detailNomor"

class="
font-black
text-lg
text-slate-800
"

>

-

</p>


</div>







<div>


<p class="
text-sm
text-slate-400
">

Perihal

</p>



<p

id="detailPerihal"

class="
font-bold
text-slate-800
"

>

-

</p>



</div>







<div class="
grid
grid-cols-2
gap-5
">



<div>


<p class="
text-sm
text-slate-400
">

Dari

</p>


<p

id="detailDari"

class="
font-bold
text-slate-800
"

>

-

</p>


</div>






<div>


<p class="
text-sm
text-slate-400
">

Kepada

</p>



<p

id="detailKepada"

class="
font-bold
text-slate-800
"

>

-

</p>


</div>



</div>










<div>


<p class="
text-sm
text-slate-400
">

Instruksi

</p>



<div

id="detailInstruksi"

class="
mt-2

bg-slate-50

border

rounded-xl

p-4

text-slate-700

"

>

-

</div>



</div>








<div class="
grid
grid-cols-2
gap-5
">


<div>

<p class="text-sm text-slate-400 mb-2">
    Deadline
</p>


<div

id="deadlineBox"

class="
rounded-xl
p-4
bg-slate-50
"

>


<p

id="detailDeadline"

class="
font-black
text-lg
text-slate-700
"

>
-
</p>



<p

id="deadlineStatus"

class="
text-sm
font-bold
mt-2
text-slate-500
"

>
-
</p>


</div>


</div>
<div>


<p class="
text-sm
text-slate-400
">

Status

</p>



<span

id="detailStatus"

class="
inline-flex
items-center

px-4
py-2

rounded-full

bg-yellow-100

text-yellow-700

font-bold

"

>

Menunggu

</span>



</div>


</div>










{{-- BUTTON AKSI --}}



<div class="
flex
justify-end
gap-3

pt-5

border-t
">





<button

type="button"

onclick="tandaiDibaca()"

class="
px-5
py-3

rounded-xl

bg-blue-600

text-white

font-bold

flex
items-center
gap-2

hover:bg-blue-700

transition
">


<i class="
fa-solid fa-eye
"></i>


Telah Dibaca


</button>







<button

type="button"

onclick="selesaikanDisposisi()"

class="
px-5
py-3

rounded-xl

bg-green-600

text-white

font-bold

flex
items-center
gap-2

hover:bg-green-700

transition
">


<i class="
fa-solid fa-check
"></i>


Selesai


</button>




</div>






</div>


</div>


</div>

{{-- ==========================================================
    MODAL BUAT DISPOSISI
========================================================== --}}


<div

id="modalDisposisi"

class="
hidden
fixed
inset-0
z-[9999]
bg-black/50
backdrop-blur-sm
items-center
justify-center
p-5
overflow-y-auto
">


<div class="
bg-white
rounded-3xl
shadow-2xl
w-full
max-w-3xl
max-h-[90vh]
overflow-hidden
flex
flex-col
">



{{-- HEADER MODAL --}}


<div class="
bg-gradient-to-r
from-blue-600
to-cyan-500
p-6
text-white
flex-shrink-0
">


<div class="
flex
justify-between
items-center
">


<div>


<h2 class="
text-2xl
font-black
flex
items-center
gap-3
">


<i class="fa-solid fa-share-from-square"></i>


Buat Disposisi Baru


</h2>



<p class="
text-sm
opacity-90
mt-1
">


Teruskan surat kepada pengguna lain


</p>


</div>





<button

type="button"

onclick="closeDisposisi()"

class="
w-10
h-10
rounded-full
bg-white/20
hover:bg-white/30
text-2xl
transition
">


×


</button>


</div>


</div>









{{-- FORM --}}


<form

action="{{ route('disposisi.store') }}"

method="POST"

class="
p-8
space-y-6
overflow-y-auto
">


@csrf



<input

type="hidden"

name="surat_id"

value="{{ $surat->id }}"

>







{{-- PILIH USER --}}


<div>


<label class="
font-bold
text-slate-700
">


Pilih Penerima Disposisi


</label>





<div class="
mt-4
grid
md:grid-cols-2
gap-4
max-h-[350px]
overflow-y-auto
pr-2
">


@foreach($users as $user)



<label class="
cursor-pointer
">


<input

type="checkbox"

name="ke_user_id[]"

value="{{ $user->id }}"

class="
peer
hidden
">


<div class="
border
border-slate-200
rounded-2xl
p-4
transition
duration-200

peer-checked:bg-blue-50
peer-checked:border-blue-600

hover:bg-slate-50
">


<div class="
flex
items-center
gap-3
">



<div class="
w-10
h-10
rounded-full
bg-blue-100
text-blue-600
flex
items-center
justify-center
flex-shrink-0
">


<i class="fa-solid fa-user"></i>


</div>





<div class="min-w-0">


<p class="
font-bold
text-slate-800
truncate
">


{{ $user->name }}


</p>



<p class="
text-xs
text-slate-500
truncate
">


{{ $user->jabatan->nama_jabatan ?? '-' }}


</p>


</div>



</div>


</div>


</label>




@endforeach



</div>


</div>









{{-- INSTRUKSI --}}


<div>


<label class="
font-bold
text-slate-700
">


Instruksi


</label>



<textarea

name="instruksi"

required

rows="4"

class="
mt-2
w-full
border
border-slate-300
rounded-xl
p-4
focus:ring-2
focus:ring-blue-500
focus:border-blue-500
"

placeholder="Tuliskan instruksi disposisi..."
></textarea>



</div>


{{-- ================= DEADLINE DISPOSISI ================= --}}

<div>

<label class="
font-bold
text-slate-700
">
Deadline Disposisi
</label>


<div class="relative">


<input

id="deadline"

type="text"

name="deadline"

required

class="
mt-2
w-full

border
border-slate-300

rounded-xl

p-4
pr-12

focus:ring-2
focus:ring-blue-500

focus:border-blue-500
"

>



<i class="
fa-solid
fa-calendar-days

absolute
right-4
top-1/2

-translate-y-1/2

text-slate-400

pointer-events-none

">
</i>


</div>



<p class="
text-sm
text-slate-400
mt-2
">
Tentukan batas waktu penyelesaian disposisi
</p>


</div>


<script>

function aktifkanDeadline(){

    let deadline = document.querySelector("#deadline");


    if(deadline && !deadline._flatpickr){

        flatpickr(deadline, {

            enableTime: true,

            time_24hr: true,

            dateFormat: "d-m-Y H:i",

            minDate: "today",

            locale:{
                firstDayOfWeek:1
            }

        });

    }

}


// jalankan saat halaman load
document.addEventListener(
    "DOMContentLoaded",
    aktifkanDeadline
);


// jalankan lagi saat modal dibuka
document.addEventListener(
    "click",
    function(){

        setTimeout(() => {

            aktifkanDeadline();

        },300);

    }
);


</script>

{{-- BUTTON --}}


<div class="
flex
justify-end
gap-3
pt-5
border-t
">





<button

type="submit"

class="
px-6
py-3
rounded-xl
bg-blue-600
text-white
font-bold
hover:bg-blue-700
transition
">


<i class="fa-solid fa-paper-plane mr-2"></i>


Kirim Disposisi


</button>


</div>




</form>


</div>


</div>




<script>

function openDisposisi()
{

    let modal = document.getElementById('modalDisposisi');


    if(!modal)
    {
        console.error('Modal disposisi tidak ditemukan');
        return;
    }


    modal.classList.remove('hidden');

    modal.classList.add('flex');


    document.body.style.overflow = 'hidden';

}





function closeDisposisi()
{

    let modal = document.getElementById('modalDisposisi');


    if(!modal)
    {
        return;
    }


    modal.classList.add('hidden');

    modal.classList.remove('flex');


    document.body.style.overflow = 'auto';

}



</script>



<script>


// ======================================================
// OPEN MODAL DETAIL DISPOSISI
// ======================================================


function openDisposisiDetail(button)
{


let id = button.dataset.id;



// simpan id disposisi

document.getElementById(
'detailDisposisiId'
).value = id;




// isi data modal


document.getElementById(
'detailNomor'
).innerText = 
button.dataset.nomor;



document.getElementById(
'detailPerihal'
).innerText = 
button.dataset.perihal;



document.getElementById(
'detailDari'
).innerText = 
button.dataset.dari;



document.getElementById(
'detailKepada'
).innerText = 
button.dataset.kepada;



document.getElementById(
'detailInstruksi'
).innerText = 
button.dataset.instruksi;
// ================= DEADLINE STATUS =================

let deadline = button.dataset.deadline;


let deadlineElement =
document.getElementById('detailDeadline');


let deadlineStatus =
document.getElementById('deadlineStatus');


let deadlineBox =
document.getElementById('deadlineBox');


// tampilkan deadline
deadlineElement.innerText = deadline;


// ubah format agar JS membaca tanggal Indonesia
let deadlineDate = new Date(
    deadline.replace(' ', 'T')
);


let now = new Date();


let diff =
(deadlineDate - now) / (1000 * 60 * 60);



// reset class

deadlineBox.className =
"rounded-xl p-4";


deadlineElement.className =
"font-black text-lg";


deadlineStatus.className =
"text-sm font-bold mt-2";





if(diff < 0)
{

    deadlineBox.classList.add(
        "bg-red-50"
    );


    deadlineElement.classList.add(
        "text-red-600"
    );


    deadlineStatus.classList.add(
        "text-red-600"
    );


    deadlineStatus.innerHTML =
    '<i class="fa-solid fa-circle-xmark"></i> Deadline Terlewat';


}

else if(diff <=24)
{

    deadlineBox.classList.add(
        "bg-yellow-50"
    );


    deadlineElement.classList.add(
        "text-yellow-600"
    );


    deadlineStatus.classList.add(
        "text-yellow-600"
    );


    deadlineStatus.innerHTML =
    '<i class="fa-solid fa-clock"></i> Segera';


}

else
{

    deadlineBox.classList.add(
        "bg-green-50"
    );


    deadlineElement.classList.add(
        "text-green-600"
    );


    deadlineStatus.classList.add(
        "text-green-600"
    );


    deadlineStatus.innerHTML =
    '<i class="fa-solid fa-circle-check"></i> Masih Aman';

}


// status

let status = button.dataset.status;



let statusBox = document.getElementById(
'detailStatus'
);



statusBox.innerText = status;



// reset class

statusBox.className =
"inline-flex px-4 py-2 rounded-full font-bold";





if(status === "Selesai")
{

statusBox.classList.add(
"bg-green-100",
"text-green-700"
);


}

else if(status === "Telah Dibaca")
{

statusBox.classList.add(
"bg-blue-100",
"text-blue-700"
);


}

else
{

statusBox.classList.add(
"bg-yellow-100",
"text-yellow-700"
);


}







// tampilkan modal


let modal = document.getElementById(
'modalDisposisiDetail'
);



modal.classList.remove(
'hidden'
);



modal.classList.add(
'flex'
);



document.body.style.overflow =
'hidden';



}









// ======================================================
// CLOSE MODAL
// ======================================================


function closeDisposisiDetail()
{


let modal =
document.getElementById(
'modalDisposisiDetail'
);



modal.classList.add(
'hidden'
);



modal.classList.remove(
'flex'
);



document.body.style.overflow =
'auto';



}









// ======================================================
// TANDAI DIBACA
// ======================================================
function tandaiDibaca()
{

let id =
document.getElementById(
'detailDisposisiId'
).value;


fetch(
`/surat/disposisi/${id}/read`,
{

method:'PUT',

headers:
{

'X-CSRF-TOKEN':
document.querySelector(
'meta[name="csrf-token"]'
).content,

'Accept':'application/json'

}

}

)

.then(response=>{


if(response.ok)
{

location.reload();

}


})


.catch(error=>{

console.log(error);

});


}

// ======================================================
// SELESAIKAN DISPOSISI
// ======================================================

function selesaikanDisposisi()
{

let id =
document.getElementById(
'detailDisposisiId'
).value;



fetch(
`/surat/disposisi/${id}/finish`,
{

method:'PUT',

headers:
{

'X-CSRF-TOKEN':
document.querySelector(
'meta[name="csrf-token"]'
).content,

'Accept':'application/json'

}

}

)

.then(response=>{


if(response.ok)
{

location.reload();

}


})


.catch(error=>{


console.log(error);


});


}



</script>
{{-- ==========================================================
    PENGESAHAN SURAT
========================================================== --}}


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
flex
justify-between
items-center
">


<div>


<h2 class="
text-xl
font-black
text-slate-800
flex
items-center
gap-3
">


<i class="
fa-solid
fa-signature
text-blue-600
">
</i>


Pengesahan Surat


</h2>



<p class="
text-sm
text-slate-500
mt-2
">


Pilih metode pengesahan surat sesuai kebutuhan.


</p>


</div>





</div>







<div class="
p-8
grid
lg:grid-cols-2
gap-6
">






{{-- ======================================================
    TTE
====================================================== --}}


<div class="
border
border-green-300
rounded-3xl
p-6
bg-green-50/40
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
">
</i>



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
">
</i>


</div>







<div class="
mt-6
grid
grid-cols-3
gap-3
text-xs
">


<div class="
bg-white
rounded-xl
p-3
text-center
">


<i class="
fa-solid
fa-shield-halved
text-green-600
">
</i>


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


<i class="
fa-solid
fa-certificate
text-green-600
">
</i>


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


<i class="
fa-solid
fa-lock
text-green-600
">
</i>


<p class="mt-2">
Tidak dapat diubah
</p>


</div>


</div>





<a href="{{ route('pengesahan.tte.form',$surat->id) }}"

class="
inline-flex
mt-6
items-center
px-8
py-3
rounded-xl
bg-blue-600
text-white
font-bold
hover:bg-blue-700
transition
">


<i class="
fa-solid
fa-signature
mr-2
">
</i>


Gunakan TTE


</a>



</div>









{{-- ======================================================
    QR CODE
====================================================== --}}


<div class="
border
border-purple-300
rounded-3xl
p-6
bg-purple-50/40
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
">
</i>



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
">
</i>


</div>







<div class="
mt-6
grid
grid-cols-3
gap-3
text-xs
">


<div class="
bg-white
rounded-xl
p-3
text-center
">


<i class="
fa-solid
fa-qrcode
text-purple-600
">
</i>


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


<i class="
fa-solid
fa-bolt
text-purple-600
">
</i>


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


<i class="
fa-solid
fa-mobile-screen
text-purple-600
">
</i>


<p class="mt-2">

Praktis

</p>


</div>


</div>






<a href="{{ route('pengesahan.qr.form',$surat->id) }}"

class="
inline-flex
mt-6
items-center
px-8
py-3
rounded-xl
bg-purple-600
text-white
font-bold
hover:bg-purple-700
transition
">


<i class="
fa-solid
fa-qrcode
mr-2
">
</i>


Gunakan QR Code


</a>



</div>




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
">
</i>


<div>


<p class="font-bold text-slate-800">

Informasi

</p>



<p class="text-sm text-slate-600">


Setelah pengesahan dilakukan, surat menjadi dokumen resmi dan tidak dapat diubah kembali.


</p>


</div>


</div>






{{-- ================= MODAL TAMBAH LAMPIRAN ================= --}}

<div
id="modalLampiran"

class="
hidden
fixed
inset-0
z-[9999]
bg-black/50
backdrop-blur-sm
flex
items-center
justify-center
p-5
"
>


<div class="
bg-white
w-full
max-w-lg
rounded-3xl
shadow-2xl
overflow-hidden
">


{{-- HEADER --}}

<div class="
bg-gradient-to-r
from-blue-600
to-cyan-500
p-6
text-white
">


<div class="
flex
justify-between
items-center
">


<div>

<h2 class="
text-2xl
font-black
flex
items-center
gap-3
">

<i class="fa-solid fa-paperclip"></i>

Tambah Lampiran Surat

</h2>


<p class="
text-sm
opacity-90
mt-1
">

Upload dokumen pendukung surat

</p>


</div>




<button

type="button"

onclick="
document.getElementById('modalLampiran').classList.add('hidden')
"

class="
w-10
h-10
rounded-full
bg-white/20
hover:bg-white/30
transition
text-xl
font-bold
"

>

<i class="fa-solid fa-xmark"></i>

</button>


</div>


</div>





{{-- BODY --}}


<form

action="{{ route('lampiran.store') }}"

method="POST"

enctype="multipart/form-data"

class="
p-8
space-y-6
"

>


@csrf



<input

type="hidden"

name="surat_id"

value="{{ $surat->id }}"

>






<div>


<label class="
font-bold
text-slate-700
flex
items-center
gap-2
">

<i class="fa-solid fa-file-arrow-up text-blue-600"></i>

Pilih File

</label>




<div class="
mt-3
border-2
border-dashed
border-blue-200
rounded-2xl
p-6
text-center
bg-blue-50/50
hover:bg-blue-50
transition
">


<i class="
fa-solid
fa-cloud-arrow-up
text-4xl
text-blue-600
mb-3
"></i>






<input

type="file"

name="file"

required

class="
w-full
text-sm
border
border-slate-300
rounded-xl
p-3
bg-white
"

>


</div>


</div>






{{-- BUTTON --}}


<div class="
flex
justify-end
gap-3
pt-5
border-t
">







<button

type="submit"

class="
px-6
py-3
rounded-xl
bg-blue-600
text-white
font-bold
hover:bg-blue-700
transition
flex
items-center
gap-2
"

>


<i class="fa-solid fa-upload"></i>


Upload


</button>


</div>



</form>



</div>


</div>


{{-- ======================================================
    MODAL DETAIL BALASAN
====================================================== --}}


<div

id="modalDetailBalasan"

class="
hidden
fixed
inset-0
z-[9999]
bg-black/50
items-center
justify-center
p-4
">


<div class="
bg-white
rounded-3xl
shadow-2xl
p-8
w-full
max-w-2xl
">


<div class="
flex
justify-between
items-center
border-b
pb-4
">


<h3
id="modalNomorSurat"

class="
text-lg
font-black
text-slate-800
">

Detail Balasan Surat

</h3>



<button

type="button"

onclick="closeModalDetailBalasan()"

class="
text-slate-400
hover:text-red-500
text-xl
">


<i class="fa-solid fa-xmark"></i>


</button>


</div>






<div class="mt-5">


<p id="modalPengirim"
class="font-bold">
</p>


<p id="modalPerihal"
class="font-bold mt-3">
</p>



<p id="modalCatatan"

class="
mt-3
bg-slate-50
p-4
rounded-xl
border
whitespace-pre-line
">
</p>


</div>







<div class="
flex
justify-end
gap-3
mt-6
border-t
pt-5
">


<button

type="button"

onclick="closeModalDetailBalasan()"

class="
px-6
py-3
bg-slate-200
rounded-xl
font-bold
">


<i class="fa-solid fa-arrow-left mr-2"></i>


Kembali


</button>




<button

onclick="window.print()"

class="
px-6
py-3
bg-blue-600
text-white
rounded-xl
font-bold
">


<i class="fa-solid fa-print mr-2"></i>


Cetak/PDF


</button>


</div>



</div>


</div>







<script>


function openModalDetailBalasan(
nomor,
pengirim,
perihal,
catatan
){


document.getElementById('modalNomorSurat').innerText =
'Detail Balasan Surat: '+nomor;


document.getElementById('modalPengirim').innerText =
pengirim;


document.getElementById('modalPerihal').innerText =
'Hal: '+perihal;


document.getElementById('modalCatatan').innerText =
catatan;



let modal =
document.getElementById('modalDetailBalasan');


modal.classList.remove('hidden');

modal.classList.add('flex');


}




function closeModalDetailBalasan(){

let modal =
document.getElementById('modalDetailBalasan');


modal.classList.add('hidden');

modal.classList.remove('flex');

}



function toggleFollow(){

document
.getElementById('followMenu')
.classList.toggle('hidden');

}


</script>


@endsection