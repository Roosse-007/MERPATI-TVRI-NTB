


@extends('layouts.app')

@section('title','Dashboard')

@section('content')

{{-- HERO SECTION --}}
<section class="
relative
overflow-hidden
rounded-[32px]
bg-gradient-to-br
from-blue-700
via-blue-600
to-cyan-400
h-72
px-10
flex
items-center
shadow-2xl
">


{{-- TEXT --}}
<div class="relative z-10">

<h1 class="
text-5xl
font-black
text-white
tracking-wide
">
MERPATI TVRI NTB
</h1>


<p class="
mt-4
text-xl
font-semibold
text-blue-100
">
Manajemen Elektronik Registrasi Surat dan Pengiriman Antar Tim
</p>


</div>



{{-- BURUNG --}}
<img
src="{{ asset('image/merpati-surat.png') }}"
class="
absolute
right-16
bottom-6
w-100
drop-shadow-2xl
dove-animation
"
/>


</section>

{{-- STATISTIC CARD --}}

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mt-10">

    {{-- SURAT MASUK --}}
   <a href="/inbox"
class="
    block
    relative
    overflow-hidden
    rounded-3xl
    p-6
    text-white
    shadow-xl
    bg-gradient-to-br
    from-sky-600
    to-blue-500
    hover:-translate-y-1
    hover:shadow-2xl
    transition-all
    duration-300
">

        <div class="
            absolute
            -right-10
            -top-10
            w-32
            h-32
            bg-white/10
            rounded-full">
        </div>

        <div class="flex items-center justify-between">

            <div>

                <p class="text-white/80 font-medium">
                    Surat Masuk
                </p>

                <h2 class="text-5xl font-black mt-3">
                    {{ $suratMasuk ?? 0 }}
                </h2>

                <p class="text-sm text-white/80 mt-4">
                    Total surat diterima
                </p>

            </div>

            <div class="
                w-16
                h-16
                rounded-2xl
                bg-white/20
                backdrop-blur
                flex
                items-center
                justify-center
            ">

                <i data-lucide="mail" class="w-8 h-8"></i>

            </div>

        </div>

    </a>



    {{-- DRAFT --}}
<a href="/surat/draft"
class="
    block
    relative
    overflow-hidden
    rounded-3xl
    p-6
    text-white
    shadow-xl
    bg-gradient-to-br
    from-violet-600
    to-fuchsia-500
    hover:-translate-y-1
    hover:shadow-2xl
    transition-all
    duration-300
">

        <div class="
            absolute
            -right-10
            -top-10
            w-32
            h-32
            bg-white/10
            rounded-full">
        </div>

        <div class="flex items-center justify-between">

            <div>

                <p class="text-white/80 font-medium">
                    Draft
                </p>

                <h2 class="text-5xl font-black mt-3">
                    {{ $draft ?? 0 }}
                </h2>

                <p class="text-sm text-white/80 mt-4">
                    Surat masih draft
                </p>

            </div>

            <div class="
                w-16
                h-16
                rounded-2xl
                bg-white/20
                backdrop-blur
                flex
                items-center
                justify-center
            ">

                <i data-lucide="file-pen-line" class="w-8 h-8"></i>

            </div>

        </div>

    </a>



    {{-- APPROVAL --}}
    <a href="/surat/approval"
class="
    block
    relative
    overflow-hidden
    rounded-3xl
    p-6
    text-white
    shadow-xl
    bg-gradient-to-br
    from-emerald-600
    to-green-500
    hover:-translate-y-1
    hover:shadow-2xl
    transition-all
    duration-300
">

        <div class="
            absolute
            -right-10
            -top-10
            w-32
            h-32
            bg-white/10
            rounded-full">
        </div>

        <div class="flex items-center justify-between">

            <div>

                <p class="text-white/80 font-medium">
                    Approval
                </p>

                <h2 class="text-5xl font-black mt-3">
                    {{ $approval ?? 0 }}
                </h2>

                <p class="text-sm text-white/80 mt-4">
                    Surat telah disetujui
                </p>

            </div>

            <div class="
                w-16
                h-16
                rounded-2xl
                bg-white/20
                backdrop-blur
                flex
                items-center
                justify-center
            ">

                <i data-lucide="badge-check" class="w-8 h-8"></i>

            </div>

        </div>

    </a>



    {{-- ARSIP --}}

<a href="/surat/arsip"
class="
    block
    relative
    overflow-hidden
    rounded-3xl
    p-6
    text-white
    shadow-xl
    bg-gradient-to-br
    from-orange-500
    to-amber-400
    hover:-translate-y-1
    hover:shadow-2xl
    transition-all
    duration-300
">

        <div class="
            absolute
            -right-10
            -top-10
            w-32
            h-32
            bg-white/10
            rounded-full">
        </div>

        <div class="flex items-center justify-between">

            <div>

                <p class="text-white/80 font-medium">
                    Arsip
                </p>

                <h2 class="text-5xl font-black mt-3">
                    {{ $arsip ?? 0 }}
                </h2>

                <p class="text-sm text-white/80 mt-4">
                    Surat telah diarsipkan
                </p>

            </div>

            <div class="
                w-16
                h-16
                rounded-2xl
                bg-white/20
                backdrop-blur
                flex
                items-center
                justify-center
            ">

                <i data-lucide="archive" class="w-8 h-8"></i>

            </div>

        </div>

    </a>
    
</div>


{{-- ========================================================= --}}
{{-- AKTIVITAS TERBARU --}}
{{-- ========================================================= --}}

<div class="bg-white rounded-[30px] shadow-lg mt-10 p-8">

    <div class="flex items-center justify-between mb-8">

        <div>

            <h2 class="text-2xl font-black text-slate-800">

                Aktivitas Terbaru

            </h2>

            <p class="text-slate-500 mt-1">

                Riwayat aktivitas terbaru pada sistem MERPATI.

            </p>

        </div>

        <div class="relative">

            <i class="bi bi-search
                absolute
                left-4
                top-1/2
                -translate-y-1/2
                text-slate-400"></i>

            <input
                id="searchAktivitas"
                type="text"
                placeholder="Cari aktivitas..."

                class="
                w-64
                pl-11
                pr-4
                py-3

                rounded-xl

                border

                bg-slate-50

                focus:ring-2
                focus:ring-blue-500
                focus:outline-none">

        </div>

    </div>

    @include('dashboard.aktivitas')

</div>


<style>
    

.flying-bird{

animation: fly 5s ease-in-out infinite;

}



@keyframes fly{


0%{

transform:
translateX(0)
translateY(0)
rotate(-8deg);

}



20%{

transform:
translateX(-20px)
translateY(-12px)
rotate(-4deg);

}



40%{

transform:
translateX(15px)
translateY(-20px)
rotate(4deg);

}



60%{

transform:
translateX(-10px)
translateY(-8px)
rotate(-2deg);

}



80%{

transform:
translateX(20px)
translateY(-15px)
rotate(5deg);

}



100%{

transform:
translateX(0)
translateY(0)
rotate(-8deg);

}



}


</style>

<script>
document.addEventListener("DOMContentLoaded", function () {

    initSearch();
    initPagination();

});

/* ==========================================================
| SEARCH
========================================================== */

function initSearch() {

    const search = document.getElementById("searchAktivitas");

    if (!search) return;

    search.addEventListener("input", function () {

        const keyword = this.value.toLowerCase().trim();

        document.querySelectorAll(".aktivitas-row").forEach(row => {

            row.style.display = row.innerText
                .toLowerCase()
                .includes(keyword)
                ? ""
                : "none";

        });

    });

}

/* ==========================================================
| PAGINATION
========================================================== */

function initPagination() {

    document.querySelectorAll(".pagination-link").forEach(link => {

        link.removeEventListener("click", handlePagination);

        link.addEventListener("click", handlePagination);

    });

}

function handlePagination(e) {

    e.preventDefault();

    const url = this.getAttribute("href");

    if (!url) return;

    loadAktivitas(url);

}

/* ==========================================================
| AJAX LOAD
========================================================== */

function loadAktivitas(url) {

    const container = document.getElementById("aktivitas-container");

    if (!container) return;

    /* Loading */

    container.style.pointerEvents = "none";
    container.style.opacity = ".35";
    container.style.transform = "translateX(20px)";
    container.style.transition = "all .3s ease";

    fetch(url, {

        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }

    })
    .then(response => {

        if (!response.ok) {
            throw new Error("Gagal memuat data.");
        }

        return response.text();

    })
    .then(html => {

        const parser = new DOMParser();

        const doc = parser.parseFromString(html, "text/html");

        const newContainer = doc.querySelector("#aktivitas-container");

        if (!newContainer) {

            throw new Error("Partial aktivitas tidak ditemukan.");

        }

        container.innerHTML = newContainer.innerHTML;

        container.style.opacity = "1";
        container.style.pointerEvents = "auto";
        container.style.transform = "translateX(0)";

        history.pushState({}, "", url);

        initSearch();
        initPagination();

        if (window.lucide) {

            lucide.createIcons();

        }

    })
    .catch(error => {

        console.error(error);

        container.style.opacity = "1";
        container.style.pointerEvents = "auto";
        container.style.transform = "translateX(0)";

    });

}

/* ==========================================================
| BACK / FORWARD
========================================================== */

window.addEventListener("popstate", function () {

    loadAktivitas(location.href);

});
</script>


@endsection