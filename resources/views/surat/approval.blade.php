<div class="space-y-6">


@forelse($surat as $item)


<div class="
bg-white
rounded-3xl
shadow-xl
border
border-slate-200
p-8
">



{{-- HEADER --}}

<div class="
flex
justify-between
items-start
gap-5
">


<div>


<h2 class="
text-xl
font-black
text-slate-800
">

{{ $item->perihal }}

</h2>



<p class="text-slate-500 mt-2">

Nomor Surat :

<span class="font-bold text-slate-700">

{{ $item->nomor_surat }}

</span>

</p>



<p class="text-sm text-slate-500 mt-3">

Pengirim :

<span class="font-bold">

{{ $item->pengirim->name ?? '-' }}

</span>

</p>


</div>







{{-- STATUS --}}

<span
class="
px-5
py-2
rounded-full
font-bold
text-sm

@if($item->status == 'Menunggu Verifikasi KPP')

bg-yellow-100
text-yellow-700


@elseif($item->status == 'Menunggu Paraf KTU')

bg-blue-100
text-blue-700


@elseif($item->status == 'Menunggu Persetujuan Kepala Stasiun')

bg-purple-100
text-purple-700


@elseif($item->status == 'Disetujui')

bg-green-100
text-green-700


@else

bg-red-100
text-red-700


@endif

">


@if($item->status == 'Menunggu Verifikasi KPP')

<i class="fa-solid fa-clock"></i>


@elseif($item->status == 'Menunggu Paraf KTU')

<i class="fa-solid fa-pen"></i>


@elseif($item->status == 'Menunggu Persetujuan Kepala Stasiun')

<i class="fa-solid fa-user-check"></i>


@elseif($item->status == 'Disetujui')

<i class="fa-solid fa-check"></i>


@else

<i class="fa-solid fa-xmark"></i>


@endif


{{ $item->status }}


</span>



</div>





<hr class="my-6">





{{-- BUTTON --}}


<div class="flex flex-wrap gap-4">





{{-- DETAIL --}}

<a href="{{ route('surat.detail',$item->id) }}"

class="
px-6
py-3
rounded-xl
bg-slate-100
font-bold
hover:bg-slate-200
transition
">

<i class="fa-solid fa-eye"></i>

Detail

</a>









{{-- ================= KPP ================= --}}


@if($item->status == 'Menunggu Verifikasi KPP')



<form method="POST"

action="{{ route('approval.kpp.approve',$item->id) }}">

@csrf


<button

class="
px-6
py-3
rounded-xl
bg-green-600
text-white
font-bold
hover:bg-green-700
">

<i class="fa-solid fa-check"></i>

Verifikasi KPP

</button>


</form>





<form method="POST"

action="{{ route('approval.kpp.reject',$item->id) }}">

@csrf


<input
type="hidden"
name="catatan"
value="Ditolak oleh KPP"
>



<button

class="
px-6
py-3
rounded-xl
bg-red-600
text-white
font-bold
hover:bg-red-700
">

<i class="fa-solid fa-xmark"></i>

Tolak

</button>


</form>




@endif







{{-- ================= KTU ================= --}}


@if($item->status == 'Menunggu Paraf KTU')



<form method="POST"

action="{{ route('approval.ktu.approve',$item->id) }}">

@csrf


<button

class="
px-6
py-3
rounded-xl
bg-blue-600
text-white
font-bold
hover:bg-blue-700
">

<i class="fa-solid fa-pen"></i>

Paraf KTU

</button>


</form>





<form method="POST"

action="{{ route('approval.ktu.reject',$item->id) }}">

@csrf


<input
type="hidden"
name="catatan"
value="Ditolak oleh KTU"
>


<button

class="
px-6
py-3
rounded-xl
bg-red-600
text-white
font-bold
hover:bg-red-700
">

<i class="fa-solid fa-xmark"></i>

Tolak

</button>


</form>




@endif








{{-- ================= KEPALA STASIUN ================= --}}



@if($item->status == 'Menunggu Persetujuan Kepala Stasiun')



<form method="POST"

action="{{ route('approval.kepala.approve',$item->id) }}">

@csrf


<button

class="
px-6
py-3
rounded-xl
bg-purple-600
text-white
font-bold
hover:bg-purple-700
">

<i class="fa-solid fa-signature"></i>

Setujui Kepala Stasiun

</button>


</form>






<form method="POST"

action="{{ route('approval.kepala.reject',$item->id) }}">

@csrf


<input
type="hidden"
name="catatan"
value="Ditolak oleh Kepala Stasiun"
>


<button

class="
px-6
py-3
rounded-xl
bg-red-600
text-white
font-bold
hover:bg-red-700
">

<i class="fa-solid fa-xmark"></i>

Tolak

</button>


</form>



@endif






</div>






{{-- DETAIL APPROVAL --}}

@if($item->approvals->count())


<div class="
mt-6
bg-slate-50
rounded-2xl
p-5
">


<h3 class="
font-bold
text-slate-700
mb-3
">

Riwayat Approval

</h3>



@foreach($item->approvals as $approval)



<div class="
flex
justify-between
text-sm
py-2
border-b
last:border-0
">


<span>

{{ $approval->approver->name ?? '-' }}

</span>



<span class="
font-bold

@if($approval->status=='Disetujui')

text-green-600

@elseif($approval->status=='Ditolak')

text-red-600

@else

text-yellow-600

@endif

">

{{ $approval->status }}

</span>



</div>


@endforeach


</div>


@endif




</div>



@empty



<div class="
bg-white
rounded-3xl
shadow
p-10
text-center
">


<i class="
fa-solid
fa-inbox
text-5xl
text-slate-300
"></i>



<p class="
mt-4
font-bold
text-slate-500
">

Tidak ada surat menunggu approval.

</p>



</div>



@endforelse



</div>