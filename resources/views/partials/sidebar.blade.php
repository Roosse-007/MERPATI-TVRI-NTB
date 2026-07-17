<aside class="relative w-72 min-h-screen overflow-hidden 
bg-gradient-to-br from-slate-950 via-blue-950 to-blue-800 
text-white shadow-2xl">


    {{-- Motif background --}}
    <div class="absolute -top-20 -right-20 
    w-64 h-64 rounded-full 
    bg-blue-400/20 blur-3xl"></div>


    <div class="absolute bottom-0 -left-20 
    w-72 h-72 rounded-full 
    bg-cyan-400/10 blur-3xl"></div>



    {{-- Logo --}}
    <div class="relative px-8 py-10">

        <div class="flex items-center gap-3">

            <div class="
            w-14 h-14 rounded-2xl
            bg-gradient-to-br from-sky-400 to-blue-700
            flex items-center justify-center
            shadow-lg shadow-blue-500/40">

                🕊️

            </div>


            <div>

                <h1 class="text-3xl font-black tracking-widest">

                    MERPATI

                </h1>


                <p class="text-sm text-blue-200">

                    TVRI NTB

                </p>

            </div>

        </div>

    </div>




    {{-- Menu --}}
    <nav class="relative px-5 mt-6 space-y-3">


        @php

        $menus=[

        ['icon'=>'🏠','name'=>'Dashboard'],

        ['icon'=>'📩','name'=>'Kotak Masuk'],

        ['icon'=>'📝','name'=>'Draft'],

        ['icon'=>'✉️','name'=>'Surat Baru'],

        ['icon'=>'✅','name'=>'Approval'],

        ['icon'=>'📌','name'=>'Disposisi'],

        ['icon'=>'🗄️','name'=>'Arsip'],

        ['icon'=>'👤','name'=>'Profil']

        ];

        @endphp



        @foreach($menus as $menu)

        <a href="#"
        class="
        group flex items-center gap-4
        px-5 py-4
        rounded-2xl
        text-blue-100
        transition-all duration-300
        
        hover:bg-white/10
        hover:backdrop-blur-xl
        hover:text-white
        hover:translate-x-2
        ">


            <span class="
            text-xl
            group-hover:scale-125
            transition">

                {{ $menu['icon'] }}

            </span>


            <span class="font-medium">

                {{ $menu['name'] }}

            </span>


        </a>

        @endforeach


    </nav>



    {{-- Bottom --}}
    <div class="
    absolute bottom-6 left-5 right-5
    rounded-3xl
    bg-white/10
    backdrop-blur-xl
    p-5">


        <p class="text-sm text-blue-100">

            Sistem E-Surat

        </p>


        <p class="font-bold">

            TVRI NTB

        </p>


    </div>


</aside>