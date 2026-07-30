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

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>


    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="overflow-x-hidden">

    <div class="flex">

        {{-- Sidebar --}}
        @include('partials.sidebar')

        <div class="flex-1 flex flex-col min-h-screen">

            {{-- Navbar --}}
            @include('partials.navbar')

            {{-- Content --}}
           <main class="
    flex-1
    ml-72
    px-8
    pt-6
    pb-8
    relative
    z-10
">

                @yield('content')

            </main>

            {{-- Footer --}}
            @include('partials.footer')

        </div>

    </div>

    {{-- Aktifkan semua icon Lucide --}}
    <script>
        lucide.createIcons();
    </script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.querySelector("nav");

    if (!sidebar) return;

    // Kembalikan posisi scroll
    const saved = sessionStorage.getItem("sidebarScroll");

    if (saved !== null) {
        sidebar.scrollTop = parseInt(saved);
    }

    // Simpan posisi scroll setiap kali digeser
    sidebar.addEventListener("scroll", function () {
        sessionStorage.setItem("sidebarScroll", sidebar.scrollTop);
    });

});
</script>

</body>

</html>