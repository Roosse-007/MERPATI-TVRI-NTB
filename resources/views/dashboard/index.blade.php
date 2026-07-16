<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

    <h1>Dashboard MERPATI TVRI NTB</h1>

    <p>Selamat datang, {{ auth()->user()->name }}</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">
            Logout
        </button>
    </form>

</body>
</html>