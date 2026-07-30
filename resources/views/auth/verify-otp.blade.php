<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi OTP - MERPATI TVRI NTB</title>

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

    {{-- Background --}}
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

                <i data-lucide="shield-check" class="w-16 h-16 text-white"></i>

            </div>

            <h1 class="
                mt-6
                text-3xl
                font-black
                tracking-[0.2em]
                text-slate-800">

                VERIFIKASI OTP

            </h1>

            <p class="mt-3 text-slate-500">

                Masukkan kode OTP yang telah dikirim ke email Anda.

            </p>

            @if(session('reset_email'))

                <p class="mt-2 text-sm font-semibold text-blue-600">

                    {{ session('reset_email') }}

                </p>

            @endif

        </div>

        {{-- Success --}}
        @if(session('success'))

        <div class="mt-8 rounded-2xl bg-green-100 border border-green-300 p-4 text-green-700">

            {{ session('success') }}

        </div>

        @endif

        {{-- Error --}}
        @if($errors->any())

        <div class="mt-8 rounded-2xl bg-red-100 border border-red-300 p-4 text-red-700">

            {{ $errors->first() }}

        </div>

        @endif

        {{-- Form --}}
        <form
            action="{{ route('password.verifyOtp') }}"
            method="POST"
            class="mt-8 space-y-6">

            @csrf

            <div>

                <label class="block mb-2 font-semibold text-slate-700">

                    Kode OTP

                </label>

                <div class="relative">

                    <i
                        data-lucide="key-round"
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

                        type="text"

                        name="otp"

                        maxlength="6"

                        minlength="6"

                        required

                        autocomplete="one-time-code"

                        inputmode="numeric"

                        pattern="[0-9]{6}"

                        placeholder="Masukkan 6 digit OTP"

                        class="
                        w-full
                        rounded-2xl
                        bg-slate-100
                        border
                        border-transparent
                        pl-12
                        py-4
                        text-center
                        text-3xl
                        tracking-[1rem]
                        font-bold
                        outline-none
                        transition-all
                        duration-300
                        focus:border-blue-500
                        focus:ring-4
                        focus:ring-blue-200">

                </div>

            </div>

            {{-- Countdown --}}
            <div class="text-center">

                <p class="text-slate-500">

                    OTP berlaku selama

                </p>

                <p
                    id="countdown"
                    class="
                    mt-2
                    text-3xl
                    font-black
                    text-red-500">

                    05:00

                </p>

            </div>

            {{-- Sisa Percobaan --}}
            @if(session('otp_remaining'))

            <div class="text-center text-sm text-slate-500">

                Sisa percobaan :
                <span class="font-bold text-blue-600">

                    {{ session('otp_remaining') }}

                </span>

            </div>

            @endif

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
                hover:-translate-y-1
                hover:shadow-blue-500/50
                transition-all">

                Verifikasi OTP

            </button>

        </form>
                {{-- Resend OTP --}}
        <div class="mt-8 text-center">

            <p class="text-slate-500 text-sm">

                Belum menerima kode OTP?

            </p>

            <button

                id="resendBtn"

                type="button"

                onclick="window.location='{{ route('password.resendOtp') }}'"

                disabled

                class="
                mt-3
                text-blue-600
                font-semibold
                opacity-50
                cursor-not-allowed
                transition-all
                duration-300
                hover:text-blue-800">

                Kirim ulang OTP

            </button>

            <p

                id="resendTimer"

                class="mt-2 text-xs text-slate-500">

                Kirim ulang dalam <span id="seconds">60</span> detik

            </p>

        </div>

        {{-- Divider --}}
        <div class="my-8 flex items-center">

            <div class="flex-1 border-t border-slate-200"></div>

            <span class="px-4 text-slate-400 text-sm">

                MERPATI TVRI NTB

            </span>

            <div class="flex-1 border-t border-slate-200"></div>

        </div>

        {{-- Back --}}
        <div class="text-center">

            <a

                href="{{ route('login') }}"

                class="
                inline-flex
                items-center
                gap-2
                text-blue-600
                hover:text-blue-800
                font-semibold">

                <i data-lucide="arrow-left"></i>

                Kembali ke Login

            </a>

        </div>

    </div>

</div>

<script>

lucide.createIcons();

/*
|--------------------------------------------------------------------------
| Countdown OTP (5 Menit)
|--------------------------------------------------------------------------
*/

let otpTime = 300;

const countdown = document.getElementById('countdown');

const timer = setInterval(function () {

    let minutes = Math.floor(otpTime / 60);

    let seconds = otpTime % 60;

    countdown.innerHTML =
        String(minutes).padStart(2,'0')
        + ":" +
        String(seconds).padStart(2,'0');

    if (otpTime <= 0) {

        clearInterval(timer);

        countdown.innerHTML = "EXPIRED";

        countdown.classList.remove("text-red-500");

        countdown.classList.add("text-red-700");

    }

    otpTime--;

},1000);

/*
|--------------------------------------------------------------------------
| Resend Countdown (60 Detik)
|--------------------------------------------------------------------------
*/

let resend = 60;

const resendBtn = document.getElementById('resendBtn');

const resendText = document.getElementById('seconds');

const resendTimer = setInterval(function(){

    resend--;

    resendText.innerHTML = resend;

    if(resend <= 0){

        clearInterval(resendTimer);

        resendBtn.disabled = false;

        resendBtn.classList.remove(
            "opacity-50",
            "cursor-not-allowed"
        );

        resendTimer.innerHTML = "";

        document.getElementById("resendTimer").innerHTML =
        "Anda dapat mengirim ulang OTP.";

    }

},1000);

/*
|--------------------------------------------------------------------------
| Hanya Angka
|--------------------------------------------------------------------------
*/

document.querySelector('input[name="otp"]').addEventListener('input', function(){

    this.value = this.value.replace(/[^0-9]/g,'');

});

</script>

</body>

</html>