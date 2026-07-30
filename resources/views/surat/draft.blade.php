@extends('layouts.app')

@section('title','Draft Surat')

@section('content')

<div class="max-w-7xl mx-auto">


{{-- HEADER --}}

<div class="flex justify-between items-center mb-5">


<div>

<div class="flex items-center gap-3">

<div class="
bg-blue-100
text-blue-600
p-3
rounded-xl
">

<i class="fa-solid fa-file-pen text-2xl"></i>

</div>


<h1 class="
text-3xl
font-black
text-slate-800
">

Draft Surat

</h1>


</div>


<p class="
text-slate-500
mt-2
">

Surat yang masih dalam proses penyusunan

</p>


</div>




<a href="{{route('surat.create')}}"

class="
bg-gradient-to-r
from-blue-600
to-cyan-400

text-white

px-6
py-3

rounded-xl

font-bold

shadow-lg

hover:scale-105

transition
">

+ Draft Baru

</a>



</div>





{{-- SEARCH FILTER --}}

<div class="
bg-white
rounded-[28px]
shadow-xl
p-5
mb-6
">


<form 
method="GET"
action="{{ route('surat.draft') }}"
>


<div class="
flex
gap-4
items-center
">


{{-- INPUT SEARCH --}}

<div class="flex-1">


<input

type="text"

name="search"

value="{{ request('search') }}"

placeholder="Cari nomor surat, perihal, atau pengirim..."

class="
w-full
bg-slate-100
border-0
rounded-2xl
px-6
py-4
text-slate-700
focus:ring-2
focus:ring-blue-500
outline-none
"

>


</div>






{{-- STATUS --}}

<div class="w-80">


<select

name="status"

class="
w-full
bg-slate-100
border-0
rounded-2xl
px-6
py-4
text-slate-700
focus:ring-2
focus:ring-blue-500
outline-none
"

>


<option value="">
Semua Status
</option>



<option value="Draft"

@if(request('status')=='Draft')
selected
@endif

>

Draft

</option>




<option value="Terkirim"

@if(request('status')=='Terkirim')
selected
@endif

>

Terkirim

</option>




<option value="Disetujui"

@if(request('status')=='Disetujui')
selected
@endif

>

Disetujui

</option>




<option value="Ditolak"

@if(request('status')=='Ditolak')
selected
@endif

>

Ditolak

</option>



</select>


</div>







{{-- BUTTON CARI --}}

<button

type="submit"

class="
bg-blue-600
hover:bg-blue-700
text-white
px-8
py-4
rounded-2xl
font-bold
transition
"

>

Cari


</button>




</div>


</form>


</div>






{{-- LIST DRAFT --}}


@forelse($draft as $item)



<div class="
bg-white
rounded-3xl
shadow-sm
border
p-6
mb-5
hover:shadow-lg
transition
">



<div class="
grid
grid-cols-12
gap-5
items-center
">






{{-- KIRI INFORMASI SURAT --}}


<div class="
col-span-12
lg:col-span-7
flex
gap-5
">


<div class="
w-16
h-16
bg-blue-100
rounded-2xl
flex
items-center
justify-center
shrink-0
">


<i class="
fa-solid
fa-file-lines
text-blue-600
text-3xl
"></i>


</div>





<div>


<h3 class="
text-xl
font-black
text-slate-800
">

{{$item->perihal}}

</h3>



<div class="
mt-3
space-y-2
text-sm
text-slate-500
">



<p class="flex gap-2 items-center">

<i class="
fa-solid
fa-hashtag
text-blue-500
"></i>


{{$item->nomor_surat ?? '-'}}


</p>





<p class="flex gap-2 items-center">


<i class="
fa-solid
fa-calendar
text-blue-500
"></i>


{{\Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d M Y')}}


</p>





@if($item->deadline)

<p class="
flex
gap-2
items-center
text-red-500
font-semibold
">


<i class="
fa-solid
fa-clock
"></i>


{{\Carbon\Carbon::parse($item->deadline)->translatedFormat('d M Y')}}


</p>


@endif






@if($item->tujuan->first())


<p class="
flex
gap-2
items-center
">


<i class="
fa-solid
fa-user
text-blue-500
"></i>


{{$item->tujuan->first()->user->name ?? '-'}}


</p>


@endif





</div>



</div>



</div>





{{-- FILE DOKUMEN --}}

<div class="
col-span-12
lg:col-span-4
flex
items-center
justify-end
gap-2
border-l
pl-4
">


@if($item->file_surat)


@php

$ext = pathinfo($item->file_surat, PATHINFO_EXTENSION);

@endphp



{{-- BOX FILE --}}

<div class="
bg-blue-50
rounded-xl
px-4
py-3
flex
items-center
gap-3
">


@if($ext == 'pdf')

<i class="
fa-solid
fa-file-pdf
text-red-600
text-3xl
"></i>


@else


<i class="
fa-solid
fa-file-word
text-blue-600
text-3xl
"></i>


@endif



<div>


<p class="
font-bold
text-sm
text-slate-700
">


{{Str::limit(
basename($item->file_surat),
18
)}}


</p>



<p class="
text-xs
text-slate-400
uppercase
">

{{$ext}}

</p>



</div>


</div>





{{-- BUTTON PREVIEW --}}


<a

href="{{route('surat.preview',$item->id)}}"

target="_blank"

class="
border
p-2
rounded-xl
hover:bg-blue-50
transition
"

title="Preview Dokumen"

>


<i class="
fa-solid
fa-eye
text-blue-600
"></i>


</a>


@endif


</div>





{{-- STATUS + MENU --}}

<div class="
col-span-12
lg:col-span-1
flex
justify-end
items-center
gap-2
pl-2
">


{{-- STATUS --}}

<span class="
bg-yellow-100
text-yellow-700
px-4
py-2
rounded-xl
font-bold
text-sm
">

{{$item->status}}

</span>



{{-- TITIK TIGA --}}

<div class="relative">


<button

onclick="toggleMenu('{{$item->id}}')"

class="
text-slate-500
text-lg
hover:text-slate-800
">

<i class="
fa-solid
fa-ellipsis-vertical
"></i>

</button>




{{-- DROPDOWN --}}

<div

id="menu{{$item->id}}"

class="
hidden
absolute
right-0
top-8
w-36
bg-white
border
rounded-xl
shadow-xl
z-50
">



{{-- EDIT --}}

<a

href="{{route('surat.edit',$item->id)}}"

class="
block
px-4
py-3
text-sm
hover:bg-green-50
text-slate-700
">

<i class="
fa-solid
fa-pen
text-green-600
mr-2
"></i>


Edit

</a>





{{-- HAPUS --}}

<form

action="{{route('surat.destroy',$item->id)}}"

method="POST"

id="delete{{$item->id}}"

>


@csrf

@method('DELETE')



<button

type="button"

onclick="hapusDraft('{{$item->id}}')"

class="
w-full
text-left
px-4
py-3
text-sm
text-red-600
hover:bg-red-50
">


<i class="
fa-solid
fa-trash
mr-2
"></i>


Hapus


</button>


</form>




</div>


</div>


</div>





</div>


</div>



@empty



<div class="
bg-white
rounded-3xl
p-10
text-center
text-slate-400
">


<div class="text-5xl mb-4">

📭

</div>


<p class="font-bold">

Belum ada draft surat

</p>



<a href="{{route('surat.create')}}"

class="
inline-block
mt-5
bg-blue-600
text-white
px-6
py-3
rounded-xl
font-bold
">

Buat Draft

</a>


</div>



@endforelse





<div class="mt-6">

{{$draft->links()}}

</div>



</div>




{{-- SWEET ALERT --}}


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>


function toggleMenu(id)
{

    let menu = document.getElementById('menu'+id);


    // tutup semua menu lain dulu
    document.querySelectorAll('[id^="menu"]').forEach(function(item){

        if(item.id !== 'menu'+id)
        {
            item.classList.add('hidden');
        }

    });


    // buka menu yang diklik
    menu.classList.toggle('hidden');

}





// klik area luar untuk menutup dropdown

document.addEventListener('click', function(event){


    let isButton = event.target.closest('button');

    let isMenu = event.target.closest('[id^="menu"]');



    if(!isButton && !isMenu)
    {


        document
        .querySelectorAll('[id^="menu"]')
        .forEach(function(menu){


            menu.classList.add('hidden');


        });


    }


});




function hapusDraft(id)

{


Swal.fire({

title:'Hapus Draft Surat?',

text:'Data yang sudah dihapus tidak dapat dikembalikan.',

icon:'warning',

showCancelButton:true,

confirmButtonText:'Ya, Hapus',

cancelButtonText:'Batal',

confirmButtonColor:'#dc2626'


}).then((result)=>{


if(result.isConfirmed)

{


document
.getElementById('delete'+id)
.submit();


}



})


}



</script>



@endsection