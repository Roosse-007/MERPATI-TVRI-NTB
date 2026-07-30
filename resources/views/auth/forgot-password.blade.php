<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lupa Password - MERPATI TVRI NTB</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

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
    <div class="absolute top-0 left-0 w-[500px] h-[500px] rounded-full bg-blue-500/20 blur-3xl"></div>

    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-cyan-400/20 blur-3xl"></div>

    {{-- Card --}}
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
            shadow-blue-500/40">

                <i data-lucide="mail-search" class="w-16 h-16 text-white"></i>

            </div>

            <h1 class="mt-6 text-4xl font-black tracking-[0.2em] text-slate-800">

                LUPA PASSWORD

            </h1>

            <p class="mt-3 text-slate-500">

                Masukkan email yang terdaftar untuk menerima kode OTP.

            </p>

        </div>

        {{-- Success --}}
        @if(session('success'))

        <div class="mt-8 rounded-2xl bg-green-100 border border-green-300 p-4 text-green-700">

            {{ session('success') }}

        </div>

        @endif

        {{-- Error --}}
        @if($errors->any())

        <div class="mt-8 rounded-2xl bg-red-100 border border-red-300 p-4 text-red-600">

            {{ $errors->first() }}

        </div>

        @endif

        {{-- Form --}}
        <form
            action="{{ route('password.sendOtp') }}"
            method="POST"
            class="mt-10 space-y-6">

            @csrf

            <div>

                <label class="block mb-2 font-semibold text-slate-700">

                    Email

                </label>

                <div class="relative">

                    <i
                        data-lucide="mail"
                        class="
                        absolute
                        left-4
                        top-1/2
                        -translate-y-1/2
                        w-5
                        h-5
                        text-blue-600">

                    </i>

                    <input

                        type="email"

                        name="email"

                        value="{{ old('email') }}"

                        required

                        autocomplete="email"

                        placeholder="Masukkan email"

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
                        focus:ring-blue-200">

                </div>

            </div>

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
                font-bold
                text-lg
                shadow-lg
                shadow-blue-500/30
                hover:shadow-blue-500/50
                hover:-translate-y-1
                transition-all
                duration-300">

                Kirim OTP

            </button>

        </form>

        {{-- Back --}}
        <div class="mt-8 text-center">

            <a

                href="{{ route('login') }}"

                class="
                inline-flex
                items-center
                gap-2
                text-blue-600
                hover:text-blue-800
                font-semibold">

                <i data-lucide="arrow-left" class="w-4 h-4"></i>

                Kembali ke Login

            </a>

        </div>

    </div>

</div>

<script>

lucide.createIcons();

</script>

</body>

</html>