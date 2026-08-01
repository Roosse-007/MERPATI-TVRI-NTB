<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MERPATI TVRI NTB')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="overflow-x-hidden bg-slate-50">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('partials.sidebar')

    {{-- AREA KANAN (Dibuat full flex column agar footer otomatis turun ke bawah) --}}
    <div class="flex-1 ml-72 flex flex-col justify-between min-h-screen">

        <div>
            {{-- NAVBAR --}}
            @include('partials.navbar')

            {{-- CONTENT --}}
        <main class="px-8 pt-6 pb-16 flex-1">
            @yield('content')
        </main>

        {{-- FOOTER YANG DIKUNCI DI TENGAH BAWAH AREA KONTEN --}}
        <footer class="py-6 text-center text-slate-400 text-sm border-t border-slate-200 mx-8">
            &copy; {{ date('Y') }} MERPATI TVRI NTB
        </footer>

    </div> <!-- Tutup area kanan -->
</div> <!-- Tutup flex min-h-screen -->
<script>
    lucide.createIcons();
</script>
</body>
</html>