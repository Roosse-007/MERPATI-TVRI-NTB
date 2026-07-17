<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title','MERPATI TVRI NTB')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-slate-100">

<div class="flex">

@include('partials.sidebar')

<div class="flex-1 flex flex-col min-h-screen">

@include('partials.navbar')

<main class="p-8">

@yield('content')

</main>

@include('partials.footer')

</div>

</div>

</body>

</html>