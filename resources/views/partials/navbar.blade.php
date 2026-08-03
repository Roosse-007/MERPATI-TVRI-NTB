<header class="
    sticky
    top-0
    z-40
    px-8
    pt-6
">


<div class="
    bg-gradient-to-r
    from-white
    via-blue-100
    to-blue-700

    rounded-3xl
    shadow-2xl

    px-8
    py-5
">


<div class="
    flex
    items-center
    justify-between
">



{{-- ================= LOGO + BRAND ================= --}}

<div class="
    flex
    items-center
    gap-6
">



{{-- LOGO TVRI --}}
<div class="
    w-28
    h-28
    flex
    items-center
    justify-center
">


<img
    src="{{ asset('image/tvri.png') }}"
    alt="Logo TVRI NTB"
    class="
        w-24
        h-24
        object-contain
        drop-shadow-xl
    "
>


</div>






{{-- TEXT --}}
<div>


<h1 class="
    text-4xl
    font-black
    tracking-wide
    text-blue-900
">

MERPATI

</h1>



<p class="
    text-blue-900
    font-bold
    text-lg
">

Sistem Informasi Surat Digital

</p>



<p class="
    text-blue-900
    text-sm
    font-bold
">
    TVRI Nusa Tenggara Barat
</p>


</div>



</div>







{{-- ================= PROFILE ================= --}}

<div>


<div class="
    flex
    items-center
    gap-4

    bg-blue-900/80

    backdrop-blur-xl

    px-5
    py-3

    rounded-2xl

    shadow-xl

    border
    border-white/20

">



<div class="
    w-12
    h-12

    rounded-xl

    bg-white/20

    flex
    items-center
    justify-center
">


<i
data-lucide="user-round"

class="
w-6
h-6
text-white
"
></i>


</div>





<div class="hidden md:block">


<p class="
font-bold
text-white
text-sm
">

{{ auth()->user()->name ?? 'Admin' }}

</p>



<p class="
text-blue-100
text-xs
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