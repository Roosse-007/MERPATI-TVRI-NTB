<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MERPATI TVRI NTB</title>
</head>
<body>

    <h1>Login MERPATI TVRI NTB</h1>

    <form method="POST" action="{{ route('login.process') }}">
        @csrf

        <div>
            <label>Username</label><br>

            <input
                type="text"
                name="username"
                value="{{ old('username') }}"
                required
                autofocus
            >

            @error('username')
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <br>

        <div>
            <label>Password</label><br>

            <input
                type="password"
                name="password"
                required
            >

            @error('password')
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <br>

        <button type="submit">
            Login
        </button>

    </form>

</body>
</html>