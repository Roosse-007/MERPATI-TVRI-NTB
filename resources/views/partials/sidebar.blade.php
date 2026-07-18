<aside class="
fixed top-0 left-0
w-72 h-screen
flex flex-col
overflow-hidden
bg-gradient-to-br from-slate-950 via-blue-950 to-blue-800
text-white
shadow-2xl
z-50
">


    {{-- Background Effect --}}
    <div class="
    absolute -top-20 -right-20
    w-64 h-64
    rounded-full
    bg-blue-400/20
    blur-3xl
    ">
    </div>


    <div class="
    absolute bottom-0 -left-20
    w-72 h-72
    rounded-full
    bg-cyan-400/10
    blur-3xl
    ">
    </div>



    {{-- LOGO --}}
    <div class="
    relative
    px-8
    py-10
    flex-shrink-0
    ">


        <div class="flex items-center gap-3">


            <div class="
            w-14 h-14
            rounded-2xl
            bg-gradient-to-br
            from-sky-400
            to-blue-700
            flex items-center justify-center
            shadow-lg
            shadow-blue-500/40
            ">

                <i data-lucide="bird"
                class="w-7 h-7 text-white">
                </i>

            </div>



            <div>

                <h1 class="
                text-3xl
                font-black
                tracking-widest
                ">
                    MERPATI
                </h1>


                <p class="
                text-sm
                text-blue-200
                ">
                    TVRI NTB
                </p>


            </div>


        </div>


    </div>






    {{-- MENU --}}
    <nav class="
    relative
    flex-1
    overflow-y-auto
    px-5
    space-y-3
    scrollbar-thin
    scrollbar-thumb-blue-400/40
    ">


@php


$current = request()->path();



$menus=[


[
'icon'=>'layout-dashboard',
'name'=>'Dashboard',
'url'=>''
],


[
'icon'=>'inbox',
'name'=>'Kotak Masuk',
'url'=>'surat/inbox'
],


[
'icon'=>'file-pen-line',
'name'=>'Draft',
'url'=>'surat/draft'
],


[
'icon'=>'file-plus',
'name'=>'Surat Baru',
'url'=>'surat/baru'
],


[
'icon'=>'circle-check-big',
'name'=>'Approval',
'url'=>'surat/approval'
],


[
'icon'=>'send',
'name'=>'Disposisi',
'url'=>'surat/disposisi'
],


[
'icon'=>'archive',
'name'=>'Arsip',
'url'=>'surat/arsip'
],


[
'icon'=>'user-round',
'name'=>'Profil',
'url'=>'profile'
]

];


@endphp





@foreach($menus as $menu)


@php

$active = $current == $menu['url'];

@endphp



<a href="/{{ $menu['url'] }}"
class="
group
flex
items-center
gap-4
px-5
py-4
rounded-2xl
transition-all
duration-300


{{ $active

?
'bg-white/20 text-white shadow-lg translate-x-2'

:

'text-blue-100 hover:bg-white/10 hover:text-white hover:translate-x-2'

}}

">


<i data-lucide="{{ $menu['icon'] }}"
class="
w-5
h-5
transition
group-hover:scale-110
">
</i>



<span class="font-medium">
{{ $menu['name'] }}
</span>



</a>


@endforeach


    </nav>







    {{-- FOOTER SIDEBAR --}}
    <div class="
    relative
    flex-shrink-0
    mx-5
    mb-6
    p-5
    rounded-3xl
    bg-white/10
    backdrop-blur-xl
    ">


        <p class="
        text-sm
        text-blue-100
        ">
            Sistem E-Surat
        </p>


        <p class="
        font-bold
        ">
            TVRI NTB
        </p>


    </div>



</aside>




<script>
    lucide.createIcons();
</script>