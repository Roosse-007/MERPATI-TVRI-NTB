<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            abort(401, 'Silakan login terlebih dahulu.');
        }


        /** @var User $user */
        $user = auth()->user();


        // Cek akun aktif
        if (!$user->is_active) {
            abort(403, 'Akun tidak aktif.');
        }


        // Cek permission Spatie
        if (!$user->can($permission)) {
            abort(403, 'Anda tidak memiliki izin.');
        }


        return $next($request);
    }
}