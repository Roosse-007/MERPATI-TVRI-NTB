<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - MERPATI TVRI NTB</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <!-- CDN Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body>

<div class="
min-h-screen
flex
items-center
justify-center
relative
overflow-hidden
bg-gradient-to-br
from-slate-950
via-blue-900
to-cyan-500
">

    {{-- Background Glow --}}
    <div class="
    absolute
    top-0
    left-0
    w-[500px]
    h-[500px]
    rounded-full
    bg-blue-500/20
    blur-3xl
    ">
    </div>

    <div class="
    absolute
    bottom-0
    right-0
    w-[500px]
    h-[500px]
    rounded-full
    bg-cyan-400/20
    blur-3xl
    ">
    </div>

    {{-- Background Logo --}}
    <div class="
    absolute
    top-10
    right-10
    opacity-10
    pointer-events-none
    ">

    </div>

    {{-- Login Card --}}
    <div class="
    relative
    w-full
    max-w-md
    bg-white/90
    backdrop-blur-xl
    border
    border-white/30
    rounded-[36px]
    shadow-2xl
    p-10
    ">

        {{-- Logo --}}
        <div class="text-center">

            <div class="
            mx-auto
            w-32
            h-32
            rounded-[32px]
            bg-gradient-to-br
            from-sky-400
            to-blue-700
            flex
            items-center
            justify-center
            shadow-xl
            shadow-blue-500/40
            relative
            overflow-hidden
            ">

                <div class="absolute inset-0 bg-gradient-to-tr from-black/10 to-transparent"></div>

                <i data-lucide="bird" class="w-16 h-16 text-white relative z-10"></i>

            </div>

            <h1 class="
            mt-6
            text-4xl
            font-black
            tracking-[0.3em]
            text-slate-800
            ">
                MERPATI
            </h1>

            <p class="
            mt-2
            text-slate-500
            ">
                Sistem E-Surat Digital
            </p>

            <p class="
            font-bold
            text-blue-600
            ">
                TVRI NUSA TENGGARA BARAT
            </p>

        </div>

        {{-- Error --}}
        @if ($errors->any())

        <div class="
        mt-8
        rounded-2xl
        bg-red-100
        border
        border-red-300
        p-4
        text-red-600
        text-sm
        ">

            {{ $errors->first() }}

        </div>

        @endif


        {{-- Form Login --}}
        <form
            action="{{ route('login.process') }}"
            method="POST"
            class="mt-10 space-y-6">

            @csrf


            {{-- Username --}}
            <div>

                <label class="
                block
                mb-2
                font-semibold
                text-slate-700
                ">
                    Username
                </label>

                <div class="relative">

                    <i
                        data-lucide="user-round"
                        class="
                        absolute
                        left-4
                        top-1/2
                        -translate-y-1/2
                        w-5
                        h-5
                        text-blue-600
                        ">
                    </i>

                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username"
                        required

                        class="
                        w-full
                        rounded-2xl
                        bg-slate-100
                        border
                        border-transparent
                        pl-12
                        pr-4
                        py-4
                        outline-none
                        transition-all
                        duration-300
                        focus:border-blue-500
                        focus:ring-4
                        focus:ring-blue-200
                        ">

                </div>

            </div>


            {{-- Password --}}
            <div>

                <label class="
                block
                mb-2
                font-semibold
                text-slate-700
                ">
                    Password
                </label>

                <div class="relative">

                    <i
                        data-lucide="lock-keyhole"
                        class="
                        absolute
                        left-4
                        top-1/2
                        -translate-y-1/2
                        w-5
                        h-5
                        text-blue-600
                        ">
                    </i>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        required

                        class="
                        w-full
                        rounded-2xl
                        bg-slate-100
                        border
                        border-transparent
                        pl-12
                        pr-12
                        py-4
                        outline-none
                        transition-all
                        duration-300
                        focus:border-blue-500
                        focus:ring-4
                        focus:ring-blue-200
                        ">

                    <button
                        type="button"
                        onclick="togglePassword()"

                        class="
                        absolute
                        right-4
                        top-1/2
                        -translate-y-1/2
                        text-slate-500
                        hover:text-blue-600
                        transition
                        ">

                        <i
                            id="eyeIcon"
                            data-lucide="eye"
                            class="w-5 h-5">
                        </i>

                    </button>

                </div>

            </div>

            {{-- Tombol Login --}}
            <button
                type="submit"
                class="
                w-full
                py-4
                rounded-2xl
                bg-gradient-to-r
                from-blue-600
                to-cyan-400
                text-white
                text-lg
                font-bold
                shadow-lg
                shadow-blue-500/30
                hover:shadow-blue-500/50
                hover:-translate-y-1
                active:scale-95
                transition-all
                duration-300
                ">

                Masuk

            </button>

        </form>


        {{-- Footer --}}
        <div class="
        mt-8
        text-center
        text-sm
        text-slate-400
        ">

            © {{ date('Y') }} MERPATI TVRI NTB

        </div>

    </div>

</div>


{{-- Javascript --}}
<script>

function togglePassword() {

    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (password.type === 'password') {

        password.type = 'text';

        eyeIcon.setAttribute('data-lucide', 'eye-off');

    } else {

        password.type = 'password';

        eyeIcon.setAttribute('data-lucide', 'eye');

    }

    lucide.createIcons();

}

// Inisialisasi semua icon Lucide
lucide.createIcons();

</script>

</body>

</html>