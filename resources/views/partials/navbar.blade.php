<header class="
sticky top-0
z-40
ml-72
px-8
pt-6
">


<div class="
bg-white/80
backdrop-blur-xl
border border-white
shadow-lg
rounded-3xl
px-8
py-5
">



<div class="flex items-center justify-between">



{{-- LEFT TITLE --}}
<div>


<h2 class="
text-3xl
font-black
text-slate-800
tracking-tight
">

@yield('title')


</h2>



<p class="
text-slate-500
mt-1
">

Sistem Informasi Surat Digital

<span class="
text-blue-600
font-semibold
">

TVRI NTB

</span>

</p>


</div>







{{-- RIGHT MENU --}}
<div class="flex items-center gap-5">



{{-- NOTIFICATION --}}

<button

class="
relative

w-12
h-12

rounded-2xl

bg-slate-100

hover:bg-blue-100

transition

flex
items-center
justify-center

"


>


<i data-lucide="bell"

class="
w-5
h-5
text-slate-600
">

</i>




<span

class="
absolute
top-2
right-2

w-3
h-3

bg-red-500

rounded-full

border-2

border-white

">

</span>


</button>









{{-- PROFILE --}}

<div

class="
flex
items-center
gap-3

bg-gradient-to-r
from-blue-600
to-cyan-400

px-4
py-2

rounded-2xl

text-white

shadow-lg

"

>



<div

class="
w-10
h-10

rounded-xl

bg-white/20

flex
items-center
justify-center

font-bold

"


>


<i data-lucide="user-round"

class="
w-5
h-5
">

</i>


</div>





<div class="hidden md:block">


<p class="
font-bold
text-sm
">

{{ auth()->user()->name ?? 'Admin' }}

</p>


<p class="
text-xs
text-blue-100
">

{{ auth()->user()->jabatan->nama_jabatan ?? 'TVRI NTB' }}

</p>



</div>


</div>





</div>


</div>


</div>


</header>



<script>

lucide.createIcons();

</script>