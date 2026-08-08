<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OtpVerified
{
    public function handle(Request $request, Closure $next): Response
    {

        if (!session('otp_verified')) {

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'otp' => 'Silakan verifikasi OTP terlebih dahulu.'
                ]);

        }


        return $next($request);

    }
}