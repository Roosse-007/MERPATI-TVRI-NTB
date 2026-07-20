@extends('layouts.app')


@section('title','Draft Surat')


@section('content')


<div class="max-w-6xl mx-auto">



{{-- HEADER --}}

<div class="mb-8">


<h1 class="
text-4xl
font-black
text-slate-800
">

📝 Draft Surat

</h1>



<p class="
text-slate-500
mt-2
">

Surat yang masih dalam proses penyusunan

</p>


</div>







{{-- CARD --}}


<div class="
bg-white
rounded-[32px]
shadow-xl
p-8
">





{{-- HEADER CARD --}}


<div class="
flex
justify-between
items-center
mb-8
">



<h2 class="
text-2xl
font-black
text-slate-800
">

Daftar Draft

</h2>





<a href="{{route('surat.create')}}"


class="
bg-gradient-to-r
from-blue-600
to-cyan-400

text-white

px-6
py-3

rounded-2xl

font-bold

shadow-lg

hover:scale-105

transition
">


+ Draft Baru


</a>



</div>









{{-- LIST DATA --}}


@forelse($draft as $item)





<div class="
bg-slate-50

rounded-2xl

p-6

mb-4

flex

justify-between

items-center

hover:bg-blue-50

transition
">







{{-- INFORMASI SURAT --}}


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



<p>

Nomor :

<span class="
font-bold
text-slate-700
">

{{$item->nomor_surat}}

</span>

</p>





<p>

Tanggal :

<span class="
font-bold
text-slate-700
">


@if($item->tanggal_surat)

{{\Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d F Y')}}

@else

-

@endif



</span>

</p>






<p>

Status :

<span class="
bg-yellow-100
text-yellow-700
px-3
py-1
rounded-full
font-bold
">

{{$item->status}}

</span>


</p>




@if($item->tujuan->first())


<p>

Kepada :

<span class="
font-bold
text-slate-700
">

{{$item->tujuan->first()->user->name ?? '-'}}

</span>


</p>


@endif




</div>




</div>









{{-- AKSI --}}


<div class="flex gap-3">





{{-- EDIT --}}


<a href="{{route('surat.edit',$item->id)}}"

class="
bg-blue-600

text-white

px-5

py-2

rounded-xl

font-bold

hover:bg-blue-700

transition
">

✏️ Edit


</a>








{{-- HAPUS --}}


<form

id="delete{{$item->id}}"

action="{{route('surat.destroy',$item->id)}}"

method="POST"

>


@csrf

@method('DELETE')




<button

type="button"

onclick="hapusDraft({{$item->id}})"

class="
bg-red-100

text-red-600

px-5

py-2

rounded-xl

font-bold

hover:bg-red-200

transition
">

🗑 Hapus


</button>



</form>







</div>






</div>







@empty





<div class="
text-center

py-12

text-slate-400
">


<div class="
text-5xl
mb-4
">

📭

</div>



<p class="font-semibold">

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

Buat Draft Pertama

</a>




</div>





@endforelse






</div>






</div>










{{-- SWEET ALERT --}}


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




<script>


function hapusDraft(id)

{


Swal.fire({

title:'Hapus Draft Surat?',

text:'Draft yang sudah dihapus tidak dapat dikembalikan.',

icon:'warning',

showCancelButton:true,


confirmButtonText:'Ya, Hapus',

cancelButtonText:'Batal',


confirmButtonColor:'#dc2626',

cancelButtonColor:'#64748b'


})

.then((result)=>{


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