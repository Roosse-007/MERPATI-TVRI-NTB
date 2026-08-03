@extends('layouts.app')

@section('title','Profil')

@section('content')

@if(session('success'))

<div
class="
mb-6
rounded-2xl
bg-green-100
border
border-green-300
text-green-700
px-6
py-4
font-semibold
shadow
flex
items-center
gap-3
">

<i data-lucide="check-circle"
class="w-6 h-6">
</i>


{{ session('success') }}


</div>

@endif

<div class="max-w-6xl mx-auto space-y-8">


{{-- HEADER PROFILE --}}
<div class="
relative
overflow-hidden
rounded-[35px]
p-10
text-white
shadow-2xl
bg-gradient-to-br
from-blue-900
via-blue-600
to-cyan-400
">


{{-- Background effect --}}
<div class="
absolute
-right-20
-top-20
w-96
h-96
rounded-full
bg-white/10
blur-3xl
">
</div>


<div class="
absolute
bottom-0
right-0
w-72
h-72
border
border-white/20
rounded-full
">
</div>



<div class="
relative
flex
items-center
gap-10
">


{{-- Avatar --}}

<div class="
w-40
h-40
rounded-full
bg-white/20
backdrop-blur-xl
border-4
border-white/40
flex
items-center
justify-center
shadow-xl
">


<i data-lucide="user-round"
class="w-20 h-20 text-white">
</i>


</div>



<div>


<h1 class="
text-5xl
font-black
tracking-wide
">

{{ $user->name }}

</h1>



<p class="
mt-3
text-xl
text-blue-100
">

Sistem MERPATI TVRI NTB

</p>



<div class="mt-5">


<span class="
inline-flex
items-center
gap-2
px-5
py-2
rounded-full
bg-white/20
backdrop-blur-md
font-semibold
">

<i data-lucide="shield-check"
class="w-5 h-5">
</i>

Pengguna Sistem

</span>


</div>


</div>


</div>


</div>






{{-- INFORMASI --}}

<div class="
bg-white
rounded-[35px]
shadow-xl
border
border-slate-100
p-10
">


<div class="flex items-center gap-3 mb-8">

<i data-lucide="user-round"
class="text-blue-600 w-7 h-7">
</i>


<h2 class="
text-3xl
font-bold
text-slate-800
">

Informasi Pribadi

</h2>


</div>





<div class="space-y-6">



{{-- Nama --}}

<div class="
flex
items-center
gap-5
p-5
rounded-2xl
bg-blue-50
">

<div class="
w-14
h-14
rounded-xl
bg-blue-600
flex
items-center
justify-center
text-white
">

<i data-lucide="user"
class="w-7 h-7">
</i>

</div>


<div>

<p class="text-slate-400 text-sm">
Nama
</p>


<p class="
font-bold
text-lg
text-slate-800
">

{{ $user->name }}

</p>


</div>


</div>







{{-- Email --}}

<div class="
flex
items-center
gap-5
p-5
rounded-2xl
bg-cyan-50
">

<div class="
w-14
h-14
rounded-xl
bg-cyan-500
flex
items-center
justify-center
text-white
">

<i data-lucide="mail"
class="w-7 h-7">
</i>

</div>



<div>

<p class="text-slate-400 text-sm">
Email
</p>


<p class="
font-bold
text-lg
text-slate-800
">

{{ $user->email }}

</p>


</div>


</div>



</div>


</div>








{{-- BUTTON ACTION --}}

<div class="
bg-white
rounded-[35px]
shadow-xl
border
border-slate-100
p-8
">


<h3 class="
text-xl
font-bold
text-slate-800
mb-5
">

Aksi

</h3>




<div class="flex gap-5">


<a href="{{ route('profile.edit') }}"
class="
px-8
py-4
rounded-2xl
font-bold
text-white
shadow-lg
bg-gradient-to-r
from-blue-700
to-cyan-400
hover:scale-105
transition
flex
items-center
gap-3
">


<i data-lucide="edit"
class="w-5 h-5">
</i>


Edit Profil

</a>






<form action="{{ route('logout') }}"
method="POST">

@csrf


<button
class="
px-8
py-4
rounded-2xl
font-bold
text-blue-700
border-2
border-blue-600
hover:bg-blue-600
hover:text-white
transition
flex
items-center
gap-3
">


<i data-lucide="log-out"
class="w-5 h-5">
</i>


Logout


</button>


</form>



</div>


</div>




</div>


@endsection