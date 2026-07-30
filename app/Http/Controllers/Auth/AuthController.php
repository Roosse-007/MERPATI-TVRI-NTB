<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
{
    return view('auth.login');
}

public function login(Request $request)
{
    $request->validate([
        'username' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    $key = Str::lower($request->username).'|'.$request->ip();

    if (RateLimiter::tooManyAttempts($key, 8)) {

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'username' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik."
        ]);

    }

    if (!Auth::attempt($request->only('username','password'))) {

        RateLimiter::hit($key, 300); // 300 detik = 5 menit

        $remaining = 8 - RateLimiter::attempts($key);

        throw ValidationException::withMessages([
            'username' => "Username atau Password salah. Sisa percobaan login: {$remaining} kali."
        ]);

        $user = Auth::user();

        if ($user->force_password_change) {

            return redirect()->route('password.change')
                ->with('warning','Silakan ganti password terlebih dahulu.');
        }

    }
    RateLimiter::clear($key);

    $request->session()->regenerate();

    return redirect()->route('dashboard');
}



public function logout(Request $request)
{

    Auth::logout();


    $request->session()->invalidate();


    $request->session()->regenerateToken();


    return redirect()
        ->route('login')
        ->with('success', 'Berhasil logout.');

}

}