@extends('layouts.app')

@section('title','Kotak Masuk')

@section('content')

<style>

.page-slide-out{
    opacity:0;
    transform:translateX(-30px);
    transition:all .35s ease;
}

.page-slide-in{
    opacity:0;
    transform:translateX(30px);
    animation:slideIn .35s ease forwards;
}

@keyframes slideIn{

    to{

        opacity:1;

        transform:translateX(0);

    }

}

</style>

<!-- ==========================================================
HEADER
========================================================== -->

<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-700 via-sky-700 to-cyan-600 shadow-xl">

    <div class="absolute -top-28 -right-28 w-96 h-96 rounded-full bg-white/10 blur-3xl"></div>

    <div class="absolute -bottom-32 -left-24 w-80 h-80 rounded-full bg-cyan-300/10 blur-3xl"></div>

    <div class="relative z-10 p-10">

        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-8">

            <div>

                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/15 text-white backdrop-blur">

                    <i class="bi bi-inbox-fill"></i>

                    Kotak Masuk

                </span>

                <h1 class="text-5xl font-black text-white mt-6">

                    Surat Masuk

                </h1>

                <p class="mt-4 text-blue-100 text-lg">

                    Seluruh surat yang diterima oleh unit kerja.

                </p>

            </div>

            <div>

                <a href="{{ route('surat.create') }}"
                   class="inline-flex items-center gap-3 bg-white text-blue-700 px-7 py-4 rounded-2xl font-bold shadow-lg hover:scale-105 transition">

                    <i class="bi bi-plus-circle-fill"></i>

                    Surat Baru

                </a>

            </div>

        </div>

    </div>

</div>

<!-- ==========================================================
STATISTIK
========================================================== -->

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mt-8">

    {{-- TOTAL SURAT --}}
    <div class="bg-gradient-to-br from-blue-600 to-cyan-500 rounded-3xl text-white shadow-xl p-8">

        <div class="flex justify-between">

            <div>

                <div class="text-blue-100">

                    Total Surat

                </div>

                <div class="counter text-5xl font-black mt-4"
                     data-target="{{ $totalSurat }}">

                    0

                </div>

            </div>

            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">

                <i class="bi bi-envelope-paper-fill text-3xl"></i>

            </div>

        </div>

    </div>

    {{-- MENUNGGU --}}
    <div class="bg-gradient-to-br from-amber-500 to-orange-400 rounded-3xl text-white shadow-xl p-8">

        <div class="flex justify-between">

            <div>

                <div class="text-amber-100">

                    Menunggu

                </div>

                <div class="counter text-5xl font-black mt-4"
                     data-target="{{ $menungguApproval }}">

                    0

                </div>

            </div>

            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">

                <i class="bi bi-hourglass-split text-3xl"></i>

            </div>

        </div>

    </div>

    {{-- DISETUJUI --}}
    <div class="bg-gradient-to-br from-green-600 to-emerald-500 rounded-3xl text-white shadow-xl p-8">

        <div class="flex justify-between">

            <div>

                <div class="text-green-100">

                    Disetujui

                </div>

                <div class="counter text-5xl font-black mt-4"
                     data-target="{{ $diterima }}">

                    0

                </div>

            </div>

            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">

                <i class="bi bi-check-circle-fill text-3xl"></i>

            </div>

        </div>

    </div>

    {{-- DITOLAK --}}
    <div class="bg-gradient-to-br from-red-500 to-rose-600 rounded-3xl text-white shadow-xl p-8">

        <div class="flex justify-between">

            <div>

                <div class="text-red-100">

                    Ditolak

                </div>

                <div class="counter text-5xl font-black mt-4"
                     data-target="{{ $ditolak }}">

                    0

                </div>

            </div>

            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">

                <i class="bi bi-file-earmark-x-fill text-3xl"></i>

            </div>

        </div>

    </div>

</div>


<!-- ==========================================================
FILTER
========================================================== -->

<div class="bg-white rounded-3xl shadow-sm border border-slate-200 mt-8 p-8">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

        {{-- SEARCH --}}
        <div class="lg:col-span-5">

            <label class="block text-sm font-semibold text-slate-700 mb-2">

                Pencarian Surat

            </label>

            <div class="relative">

                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                <input
                    id="searchInput"
                    name="search"
                    value="{{ request('search') }}"
                    type="text"
                    placeholder="Nomor surat, perihal, pengirim..."
                    class="w-full rounded-2xl border border-slate-200 pl-12 pr-4 py-4 focus:ring-2 focus:ring-blue-500 outline-none">

            </div>

        </div>

        {{-- STATUS --}}
        <div class="lg:col-span-3">

            <label class="block text-sm font-semibold text-slate-700 mb-2">

                Status

            </label>

            <select
                id="statusFilter"
                name="status"
                class="w-full rounded-2xl border border-slate-200 px-5 py-4 focus:ring-2 focus:ring-blue-500 outline-none">

                <option value="">Semua Status</option>

                <option value="Draft"
                    @selected(request('status')=='Draft')>

                    Draft

                </option>

                <option value="Menunggu Approval KPP"
                    @selected(request('status')=='Menunggu Approval KPP')>

                    Menunggu Approval KPP

                </option>

                <option value="Menunggu Approval KTU"
                    @selected(request('status')=='Menunggu Approval KTU')>

                    Menunggu Approval KTU

                </option>

                <option value="Menunggu Approval Kepala Stasiun"
                    @selected(request('status')=='Menunggu Approval Kepala Stasiun')>

                    Menunggu Approval Kepala Stasiun

                </option>

                <option value="Disetujui"
                    @selected(request('status')=='Disetujui')>

                    Disetujui

                </option>

                <option value="Ditolak"
                    @selected(request('status')=='Ditolak')>

                    Ditolak

                </option>

            </select>

        </div>

        {{-- SORT --}}
        <div class="lg:col-span-2">

            <label class="block text-sm font-semibold text-slate-700 mb-2">

                Urutkan

            </label>

           <select
                id="sortFilter"
                name="sort"
                class="w-full rounded-2xl border border-slate-200 px-5 py-4">

                <option value="desc"
                @selected(request('sort')=='desc')
>

                    Terbaru

                </option>

                <option value="asc"
                @selected(request('sort')=='asc')
>

                    Terlama

                </option>

            </select>

        </div>

        {{-- BUTTON --}}
        <div class="lg:col-span-2 flex items-end">

            <button
                id="btnFilter"
                class="w-full rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 text-white py-4 font-bold hover:shadow-xl transition">

                <i class="bi bi-funnel-fill me-2"></i>

                Terapkan

            </button>

        </div>

    </div>

</div>

<!-- ==========================================================
INFO BAR
========================================================== -->


<!-- ==========================================================
TABEL SURAT
========================================================== -->
<div id="tableContainer">

    @include('surat.partials.inbox-table')

</div>



<script>

document.addEventListener('DOMContentLoaded', function () {

    /*====================================================
    COUNTER
    ====================================================*/

    document.querySelectorAll('.counter').forEach(counter => {

        const target = Number(counter.dataset.target);

        let current = 0;

        const step = Math.max(1, Math.ceil(target / 60));

        const timer = setInterval(() => {

            current += step;

            if(current >= target){

                current = target;

                clearInterval(timer);

            }

            counter.innerText = current.toLocaleString('id-ID');

        },20);

    });


    /*====================================================
    FILTER DATABASE
    ====================================================*/

    const btnFilter = document.getElementById('btnFilter');

    if(btnFilter){

        btnFilter.addEventListener('click',applyFilter);

    }

    document.getElementById('searchInput')

    ?.addEventListener('keypress',function(e){

        if(e.key==="Enter"){

            applyFilter();

        }

    });

    function applyFilter(){

        const search = document.getElementById('searchInput').value;

        const status = document.getElementById('statusFilter').value;

        const sort = document.getElementById('sortFilter').value;

        const params = new URLSearchParams();

        if(search){

            params.append('search',search);

        }

        if(status){

            params.append('status',status);

        }

        if(sort){

            params.append('sort',sort);

        }

        loadPage(

            "{{ route('surat.inbox') }}?"+params.toString()

        );

    }


    /*====================================================
    INIT EVENT
    ====================================================*/

    function initEvents(){

        // Hover Row

        document.querySelectorAll('.surat-row').forEach(function(row){

            row.onmouseenter=function(){

                this.classList.add('shadow-sm');

            };

            row.onmouseleave=function(){

                this.classList.remove('shadow-sm');

            };

        });


        // Pagination

        document.querySelectorAll('.pagination-link').forEach(function(link){

            link.onclick=function(e){

                e.preventDefault();

                loadPage(this.href);

            };

        });

    }

    /*====================================================
    DOWNLOAD LOADING
    ====================================================*/

    document.querySelectorAll('.download-btn').forEach(function(btn){

        btn.onclick=function(){

            const icon=this.querySelector('i');

            icon.className='bi bi-arrow-repeat animate-spin';

        };

    });

    /*====================================================
    AJAX LOAD PAGE
    ====================================================*/

    function loadPage(url){

        const container=document.getElementById('tableContainer');

        container.style.transition='all .35s ease';

        container.style.opacity='.25';

        container.style.transform='translateX(35px)';

        fetch(url,{

            headers:{

                'X-Requested-With':'XMLHttpRequest'

            }

        })

        .then(res=>res.text())

        .then(html=>{

            container.innerHTML=html;

            container.style.opacity='1';

            container.style.transform='translateX(0)';

            history.pushState({},'',url);

            initEvents();

        })

        .catch(err=>{

            console.error(err);

        });

    }


    /*====================================================
    BACK BUTTON
    ====================================================*/

    window.addEventListener('popstate',function(){

        loadPage(location.href);

    });


    /*====================================================
    START
    ====================================================*/

    initEvents();

});

</script>

@endsection