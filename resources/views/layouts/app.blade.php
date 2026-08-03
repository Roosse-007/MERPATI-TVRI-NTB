<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MERPATI TVRI NTB')</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"

    rel="stylesheet">

    <link 

    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])



    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>


    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


</head><body class="overflow-x-hidden bg-slate-50">


<div class="flex min-h-screen">


    {{-- SIDEBAR --}}
    @include('partials.sidebar')


    {{-- AREA KANAN --}}
    <div class="flex-1 ml-72 flex flex-col min-h-screen">


        {{-- NAVBAR --}}
        @include('partials.navbar')


        {{-- CONTENT --}}
        <main class="
            flex-1
            px-8
            pt-6
            pb-16
            relative
        ">

            @yield('content')

        </main>



        {{-- FOOTER --}}
        <footer class="
            py-6
            text-center
            text-slate-400
            text-sm
            border-t
            border-slate-200
            mx-8
        ">

            &copy; {{ date('Y') }} MERPATI TVRI NTB

        </footer>


    </div>


</div>



<script>
lucide.createIcons();
</script>



{{-- Menyimpan posisi scroll sidebar --}}
<script>

document.addEventListener("DOMContentLoaded", function(){

    const sidebar = document.querySelector("nav");

    if(!sidebar) return;


    const saved = sessionStorage.getItem("sidebarScroll");


    if(saved !== null){

        sidebar.scrollTop = parseInt(saved);

    }


    sidebar.addEventListener("scroll", function(){

        sessionStorage.setItem(
            "sidebarScroll",
            sidebar.scrollTop
        );

    });


});

</script>



{{-- Resize Chart --}}
<script>

window.addEventListener('load', function(){

    if(window.Chart){

        Object.values(Chart.instances)
        .forEach(function(chart){

            chart.resize();

        });

    }

});

</script>



<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


</body>
</html>