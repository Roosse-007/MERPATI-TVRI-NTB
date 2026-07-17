@extends('layouts.app')

@section('title','Profil')

@section('content')


<div class="max-w-5xl mx-auto">


{{-- Header Profile --}}

<div class="
relative
overflow-hidden
rounded-[32px]
bg-gradient-to-r
from-blue-700
to-cyan-400
p-10
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
">
</div>



<div class="
relative
flex
items-center
gap-8
">


<div class="
w-32
h-32
rounded-full
bg-white/20
backdrop-blur-xl
border-4
border-white/50
flex
items-center
justify-center
text-6xl
">

👤

</div>



<div>

<h1 class="
text-4xl
font-black
">

Admin TVRI NTB

</h1>


<p class="
text-blue-100
mt-2
">

Administrator Sistem E-Surat

</p>


</div>


</div>


</div>




{{-- Detail --}}

<div class="
mt-8
grid
md:grid-cols-2
gap-6
">


<div class="
bg-white
rounded-[28px]
p-8
shadow-lg
">


<h2 class="
text-xl
font-bold
mb-6
">

Informasi Pribadi

</h2>



<div class="space-y-5">


<div>

<p class="text-slate-400 text-sm">
Nama
</p>

<p class="font-bold">
Admin TVRI
</p>

</div>



<div>

<p class="text-slate-400 text-sm">
Email
</p>

<p class="font-bold">
admin@tvri.com
</p>

</div>



<div>

<p class="text-slate-400 text-sm">
No Telepon
</p>

<p class="font-bold">
0812xxxxxxx
</p>

</div>


</div>


</div>





<div class="
bg-white
rounded-[28px]
p-8
shadow-lg
">


<h2 class="
text-xl
font-bold
mb-6
">

Informasi Pekerjaan

</h2>



<div class="space-y-5">


<div>

<p class="text-slate-400 text-sm">
Unit Kerja
</p>

<p class="font-bold">
TVRI NTB
</p>

</div>



<div>

<p class="text-slate-400 text-sm">
Jabatan
</p>

<p class="font-bold">
Administrator
</p>

</div>



<div>

<p class="text-slate-400 text-sm">
Role
</p>

<p class="
inline-block
bg-blue-100
text-blue-700
px-4
py-2
rounded-xl
font-bold
">

Admin

</p>

</div>



</div>


</div>



</div>





<button class="
mt-8
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

Edit Profil

</button>



</div>


@endsection