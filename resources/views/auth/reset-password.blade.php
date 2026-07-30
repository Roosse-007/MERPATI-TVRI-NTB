<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - MERPATI TVRI NTB</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body>

<div class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-slate-950 via-blue-900 to-cyan-500">

    {{-- Background --}}
    <div class="absolute top-0 left-0 w-[500px] h-[500px] rounded-full bg-blue-500/20 blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-cyan-400/20 blur-3xl"></div>

    {{-- Card --}}
    <div class="relative w-full max-w-md bg-white/90 backdrop-blur-xl border border-white/30 rounded-[36px] shadow-2xl p-10">

        {{-- Logo --}}
        <div class="text-center">

            <div class="mx-auto w-32 h-32 rounded-[32px] bg-gradient-to-br from-sky-400 to-blue-700 flex items-center justify-center shadow-xl shadow-blue-500/40">

                <i data-lucide="lock-keyhole" class="w-16 h-16 text-white"></i>

            </div>

            <h1 class="mt-6 text-3xl font-black tracking-[0.2em] text-slate-800">

                RESET PASSWORD

            </h1>

            <p class="mt-3 text-slate-500">

                Buat password baru untuk akun Anda.

            </p>

        </div>

        {{-- Success --}}
        @if(session('success'))

        <div class="mt-6 rounded-2xl bg-green-100 border border-green-300 p-4 text-green-700">

            {{ session('success') }}

        </div>

        @endif

        {{-- Error --}}
        @if($errors->any())

        <div class="mt-6 rounded-2xl bg-red-100 border border-red-300 p-4 text-red-700">

            {{ $errors->first() }}

        </div>

        @endif

        <form
            action="{{ route('password.reset') }}"
            method="POST"
            class="mt-8 space-y-6">

            @csrf

            {{-- Password Baru --}}
            <div>

                <label class="block mb-2 font-semibold text-slate-700">

                    Password Baru

                </label>

                <div class="relative">

                    <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-blue-600"></i>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        minlength="8"
                        autocomplete="new-password"
                        placeholder="Masukkan password baru"

                        class="w-full rounded-2xl bg-slate-100 border border-transparent pl-12 pr-14 py-4 outline-none transition-all duration-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200">

                    <button
                        type="button"
                        id="togglePassword"
                        class="absolute right-4 top-1/2 -translate-y-1/2">

                        <i id="eyePassword" data-lucide="eye" class="w-5 h-5 text-gray-500"></i>

                    </button>

                </div>

                {{-- Progress --}}
                <div class="mt-4 w-full h-2 bg-gray-200 rounded-full overflow-hidden">

                    <div
                        id="strengthBar"
                        class="h-full w-0 bg-red-500 transition-all duration-300">

                    </div>

                </div>

                <p
                    id="strengthText"
                    class="mt-2 text-sm text-gray-500">

                    Password belum diisi

                </p>

            </div>

            {{-- Checklist --}}
            <div class="space-y-2 text-sm">

                <div id="ruleLength" class="text-gray-500">

                    ✖ Minimal 8 karakter

                </div>

                <div id="ruleUpper" class="text-gray-500">

                    ✖ Mengandung huruf besar

                </div>

                <div id="ruleLower" class="text-gray-500">

                    ✖ Mengandung huruf kecil

                </div>

                <div id="ruleNumber" class="text-gray-500">

                    ✖ Mengandung angka

                </div>

            </div>

            {{-- Konfirmasi Password --}}
            <div>

                <label class="block mb-2 font-semibold text-slate-700">

                    Konfirmasi Password

                </label>

                <div class="relative">

                    <i data-lucide="shield-check" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-blue-600"></i>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Ulangi password"

                        class="w-full rounded-2xl bg-slate-100 border border-transparent pl-12 pr-14 py-4 outline-none transition-all duration-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200">

                    <button
                        type="button"
                        id="toggleConfirm">

                        <i id="eyeConfirm"
                           data-lucide="eye"
                           class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500"></i>

                    </button>

                </div>

                <p
                    id="matchText"
                    class="mt-2 text-sm text-gray-500">

                    Menunggu konfirmasi password...

                </p>

            </div>

            <button
                id="submitBtn"
                type="submit"
                disabled

                class="w-full py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white text-lg font-bold shadow-lg opacity-50 cursor-not-allowed">

                Simpan Password

            </button>

        </form>

        <div class="mt-8 text-center">

            <a
                href="{{ route('login') }}"
                class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold">

                <i data-lucide="arrow-left"></i>

                Kembali ke Login

            </a>

        </div>

    </div>

</div>

<script>

lucide.createIcons();

/* =====================================================
   SHOW / HIDE PASSWORD
===================================================== */

const passwordInput = document.getElementById("password");
const confirmInput = document.getElementById("password_confirmation");

const togglePassword = document.getElementById("togglePassword");
const toggleConfirm = document.getElementById("toggleConfirm");

const eyePassword = document.getElementById("eyePassword");
const eyeConfirm = document.getElementById("eyeConfirm");

togglePassword.addEventListener("click", function () {

    if (passwordInput.type === "password") {

        passwordInput.type = "text";

        eyePassword.setAttribute("data-lucide","eye-off");

    } else {

        passwordInput.type = "password";

        eyePassword.setAttribute("data-lucide","eye");

    }

    lucide.createIcons();

});

toggleConfirm.addEventListener("click", function () {

    if (confirmInput.type === "password") {

        confirmInput.type = "text";

        eyeConfirm.setAttribute("data-lucide","eye-off");

    } else {

        confirmInput.type = "password";

        eyeConfirm.setAttribute("data-lucide","eye");

    }

    lucide.createIcons();

});


/* =====================================================
   PASSWORD STRENGTH
===================================================== */

const bar = document.getElementById("strengthBar");
const text = document.getElementById("strengthText");

const submitBtn = document.getElementById("submitBtn");

const ruleLength = document.getElementById("ruleLength");
const ruleUpper = document.getElementById("ruleUpper");
const ruleLower = document.getElementById("ruleLower");
const ruleNumber = document.getElementById("ruleNumber");

const matchText = document.getElementById("matchText");

function updateChecklist(element, valid, successText, failText){

    if(valid){

        element.className = "text-green-600 font-semibold";

        element.innerHTML = "✔ " + successText;

    }else{

        element.className = "text-red-500";

        element.innerHTML = "✖ " + failText;

    }

}

function validatePassword(){

    const password = passwordInput.value;

    let score = 0;

    const length = password.length >= 8;
    const upper = /[A-Z]/.test(password);
    const lower = /[a-z]/.test(password);
    const number = /[0-9]/.test(password);

    updateChecklist(ruleLength,length,"Minimal 8 karakter","Minimal 8 karakter");
    updateChecklist(ruleUpper,upper,"Huruf besar","Mengandung huruf besar");
    updateChecklist(ruleLower,lower,"Huruf kecil","Mengandung huruf kecil");
    updateChecklist(ruleNumber,number,"Angka","Mengandung angka");

    if(length) score++;
    if(upper) score++;
    if(lower) score++;
    if(number) score++;

    bar.classList.remove(
        "bg-red-500",
        "bg-yellow-500",
        "bg-green-500"
    );

    if(score==0){

        bar.style.width="0%";

        text.innerHTML="Password belum diisi";

    }

    if(score==1){

        bar.style.width="25%";

        bar.classList.add("bg-red-500");

        text.innerHTML="Lemah";

    }

    if(score==2){

        bar.style.width="50%";

        bar.classList.add("bg-yellow-500");

        text.innerHTML="Sedang";

    }

    if(score==3){

        bar.style.width="75%";

        bar.classList.add("bg-green-500");

        text.innerHTML="Baik";

    }

    if(score==4){

        bar.style.width="100%";

        bar.classList.add("bg-green-500");

        text.innerHTML="Sangat Kuat";

    }

    validateConfirmation();

}

/* =====================================================
   CONFIRM PASSWORD
===================================================== */

function validateConfirmation(){

    if(confirmInput.value===""){

        matchText.className="text-gray-500 mt-2 text-sm";

        matchText.innerHTML="Menunggu konfirmasi password...";

        submitBtn.disabled=true;

        submitBtn.classList.add(
            "opacity-50",
            "cursor-not-allowed"
        );

        return;

    }

    if(passwordInput.value===confirmInput.value){

        matchText.className="text-green-600 mt-2 text-sm font-semibold";

        matchText.innerHTML="✔ Password cocok";

    }else{

        matchText.className="text-red-600 mt-2 text-sm font-semibold";

        matchText.innerHTML="✖ Password tidak sama";

    }

    const validPassword =
        passwordInput.value.length>=8 &&
        /[A-Z]/.test(passwordInput.value) &&
        /[a-z]/.test(passwordInput.value) &&
        /[0-9]/.test(passwordInput.value);

    if(validPassword && passwordInput.value===confirmInput.value){

        submitBtn.disabled=false;

        submitBtn.classList.remove(
            "opacity-50",
            "cursor-not-allowed"
        );

    }else{

        submitBtn.disabled=true;

        submitBtn.classList.add(
            "opacity-50",
            "cursor-not-allowed"
        );

    }

}

passwordInput.addEventListener("keyup",validatePassword);

confirmInput.addEventListener("keyup",validateConfirmation);

</script>

</body>
</html>