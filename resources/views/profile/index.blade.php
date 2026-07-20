@extends('layouts.app')

@section('title','Profil')

@section('content')


<div class="max-w-5xl mx-auto">


{{-- Header Profile --}}

<div class="
relative
overflow-hidden
rounded-[36px]
bg-gradient-to-r
from-blue-700
via-blue-600
to-cyan-400
px-10
py-8
text-white
shadow-2xl
border
border-white/20
">

    {{-- Blur Background --}}
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

    {{-- Lingkaran Dekoratif --}}
    <div class="
    absolute
    -bottom-10
    -right-10
    w-72
    h-72
    border
    border-white/10
    rounded-full
    ">
    </div>

    <div class="
    absolute
    -bottom-20
    -right-20
    w-96
    h-96
    border
    border-white/5
    rounded-full
    ">
    </div>

    <div class="
    relative
    flex
    items-center
    gap-8
    ">


<div class="
w-36
h-36
rounded-full
bg-white/20
backdrop-blur-xl
border-4
border-white/40
flex
items-center
justify-center
shadow-2xl
">

<i data-lucide="user-round"
class="w-16 h-16 text-white">
</i>

</div>



<div>

<h1 class="
text-4xl
font-black
">

Admin TVRI NTB

</h1>


<p class="text-blue-100 mt-2">
    Administrator Sistem E-Surat
</p>

<div class="mt-4 flex items-center gap-3">

    <span class="
    px-4
    py-2
    rounded-full
    bg-white/20
    backdrop-blur
    text-sm
    font-semibold
    ">
        Administrator
    </span>

</div>


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
rounded-[30px]
p-8
shadow-xl
border
border-slate-100
hover:-translate-y-1
hover:shadow-2xl
transition-all
duration-300
">


<div class="flex items-center gap-3 mb-6">

<i
data-lucide="user-round"
class="w-6 h-6 text-blue-600">
</i>

<h2 class="text-2xl font-bold">

Informasi Pribadi

</h2>

</div>




<div class="space-y-5">


<div>

<p class="flex items-center gap-2 text-slate-400 text-sm">
    <i data-lucide="user" class="w-4 h-4"></i>
    Nama
</p>

<p class="font-bold">
Admin TVRI
</p>

</div>



<div>

<p class="flex items-center gap-2 text-slate-400 text-sm">
    <i data-lucide="mail" class="w-4 h-4"></i>
    Email
</p>
<p class="font-bold">
admin@tvri.com
</p>

</div>



<div>

<p class="flex items-center gap-2 text-slate-400 text-sm">
    <i data-lucide="phone" class="w-4 h-4"></i>
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
rounded-[30px]
p-8
shadow-xl
border
border-slate-100
hover:-translate-y-1
hover:shadow-2xl
transition-all
duration-300
">


<div class="flex items-center gap-3 mb-6">

<i
data-lucide="briefcase-business"
class="w-6 h-6 text-cyan-600">
</i>

<h2 class="text-2xl font-bold">

Informasi Pekerjaan

</h2>

</div>




<div class="space-y-5">


<div>

<p class="flex items-center gap-2 text-slate-400 text-sm">
    <i data-lucide="building-2" class="w-4 h-4"></i>
    Unit Kerja
</p>
<p class="font-bold">
TVRI NTB
</p>

</div>



<div>

<p class="flex items-center gap-2 text-slate-400 text-sm">
    <i data-lucide="briefcase-business" class="w-4 h-4"></i>
    Jabatan
</p>

<p class="font-bold">
Administrator
</p>

</div>



<div>

<p class="flex items-center gap-2 text-slate-400 text-sm">
    <i data-lucide="shield-check" class="w-4 h-4"></i>
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





<div class="flex items-center gap-4 mt-8">

    {{-- Tombol Edit Profil --}}
    <button class="
    bg-gradient-to-r
    from-blue-600
    to-cyan-400
    text-white
    px-8
    py-4
    rounded-2xl
    font-bold
    shadow-lg
    hover:-translate-y-1
    hover:shadow-xl
    transition-all
    duration-300
    transition
    ">
        Edit Profil
    </button>

    {{-- Tombol Logout --}}
    <form action="{{ route('logout') }}" method="POST">

        @csrf

        <button
            type="submit"
            class="
            bg-gradient-to-r
            from-red-500
            to-red-700
            text-white
            px-8
            py-4
            rounded-2xl
            font-bold
            shadow-lg
            hover:scale-105
            transition
            flex
            items-center
            gap-2
            ">

            <i data-lucide="log-out" class="w-5 h-5"></i>

            Logout

        </button>

    </form>

</div>



</div>


@endsection