<header class="
sticky
top-0
z-40
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



{{-- LEFT LOGO --}}
<div class="flex items-center gap-3">

<!-- GANTI BAGIAN INI DENGAN FILE GAMBAR LOGO ANDA -->
<div class="w-35 h-35 flex items-center justify-center shrink-0">
    <img src="{{ asset('image/tvri.png') }}"
         alt="Logo TVRI NTB"
         class="w-full h-full object-contain">
</div>

<div>


</div>

</div>







{{-- RIGHT MENU --}}
<div class="flex items-center gap-5">

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