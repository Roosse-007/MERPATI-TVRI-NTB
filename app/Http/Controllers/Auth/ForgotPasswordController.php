<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordResetOtp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan halaman lupa password
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim OTP ke email
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = strtolower(trim($request->email));

        /*
        |--------------------------------------------------------------------------
        | Rate Limit
        | Maksimal 3 kali request OTP dalam 15 menit
        |--------------------------------------------------------------------------
        */

        $key = 'forgot-password:' . $request->ip() . ':' . $email;

        if (RateLimiter::tooManyAttempts($key, 3)) {

            $seconds = RateLimiter::availableIn($key);

            return back()->withErrors([
                'email' => "Terlalu banyak permintaan OTP. Silakan coba lagi dalam {$seconds} detik."
            ])->withInput();
        }

        RateLimiter::hit($key, 900); // 15 menit

        /*
        |--------------------------------------------------------------------------
        | Cari User
        |--------------------------------------------------------------------------
        */

        $user = User::where('email', $email)->first();

        if (!$user) {

            // Logging untuk audit
            Log::warning('Forgot password menggunakan email yang tidak terdaftar.', [
                'email' => $email,
                'ip' => $request->ip(),
            ]);

            // Demi keamanan jangan beritahu apakah email ada atau tidak
            return back()->with(
                'success',
                'Jika email tersebut terdaftar, kode OTP akan dikirim ke alamat email tersebut.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Cek apakah OTP lama masih aktif
        |--------------------------------------------------------------------------
        */

        $existingOtp = PasswordResetOtp::where('email', $email)
            ->where('expired_at', '>', now())
            ->first();

        if ($existingOtp) {

            return back()->with(
                'success',
                'Kode OTP masih aktif. Silakan cek email Anda atau tunggu hingga OTP kadaluarsa.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Generate OTP
        |--------------------------------------------------------------------------
        */

        $otp = random_int(100000, 999999);

        PasswordResetOtp::updateOrCreate(

            [
                'email' => $email,
            ],

            [
                'otp' => Hash::make($otp),
                'attempts' => 0,
                'expired_at' => Carbon::now()->addMinutes(5),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Kirim Email
        |--------------------------------------------------------------------------
        */

        try {

            Mail::raw(
                "Halo {$user->username},

Kode OTP untuk reset password MERPATI TVRI NTB adalah:

{$otp}

Kode ini berlaku selama 5 menit.

Apabila Anda tidak melakukan permintaan reset password, abaikan email ini.

MERPATI TVRI NTB",
                function ($mail) use ($email) {

                    $mail->to($email)
                        ->subject('Kode OTP Reset Password MERPATI TVRI NTB');
                }
            );

        } catch (\Exception $e) {

            Log::error('Gagal mengirim OTP.', [
                'email' => $email,
                'message' => $e->getMessage(),
            ]);

            return back()->withErrors([
                'email' => 'Gagal mengirim email OTP. Silakan coba beberapa saat lagi.'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan Session
        |--------------------------------------------------------------------------
        */

        session([
            'reset_email' => $email,
        ]);

        Log::info('OTP berhasil dikirim.', [
            'email' => $email,
        ]);

        return redirect()->route('password.verify');
    }

    /**
 * Tampilkan halaman verifikasi OTP
 */
public function showVerifyOtp()
{
    return view('auth.verify-otp');
}
public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => [
            'required',
            'digits:6'
        ],
    ]);


    $email = session('reset_email');


    if (!$email) {

        return redirect()
            ->route('password.request')
            ->withErrors([
                'email' => 'Sesi reset password sudah habis.'
            ]);

    }


    $otpData = PasswordResetOtp::where('email', $email)
        ->first();


    if (!$otpData) {

        return back()->withErrors([
            'otp' => 'OTP tidak ditemukan.'
        ]);

    }



    // cek expired

    if (Carbon::now()->greaterThan($otpData->expired_at)) {

        return back()->withErrors([
            'otp' => 'Kode OTP sudah kadaluarsa.'
        ]);

    }



    // cek OTP

    if (!Hash::check($request->otp, $otpData->otp)) {


        $otpData->increment('attempts');


        return back()->withErrors([
            'otp' => 'Kode OTP salah.'
        ]);

    }



    // OTP benar

    session([
        'otp_verified' => true
    ]);


    return redirect()
        ->route('password.reset.form');

}
/**
 * Tampilkan halaman reset password
 */
public function showResetForm()
{
    return view('auth.reset-password');
}
/**
 * Simpan password baru
 */
public function resetPassword(Request $request)
{
    $request->validate([
        'password' => [
            'required',
            'confirmed',
            'min:8'
        ],
    ]);


    $email = session('reset_email');


    if (!$email) {

        return redirect()
            ->route('password.request')
            ->withErrors([
                'email' => 'Sesi reset password sudah habis.'
            ]);

    }


    $user = User::where('email', $email)->first();


    if (!$user) {

        return redirect()
            ->route('password.request')
            ->withErrors([
                'email' => 'User tidak ditemukan.'
            ]);

    }


    // Update password

    $user->update([
        'password' => Hash::make($request->password),
    ]);



    // Hapus OTP setelah berhasil

    PasswordResetOtp::where('email', $email)->delete();



    // Bersihkan session reset

    session()->forget([
        'reset_email',
        'otp_verified'
    ]);



    return redirect()
        ->route('login')
        ->with(
            'success',
            'Password berhasil diubah. Silakan login dengan password baru.'
        );

}
}