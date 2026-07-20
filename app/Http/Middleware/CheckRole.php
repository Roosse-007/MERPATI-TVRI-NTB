<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;


class CheckRole
{
    
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            abort(401, 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();

        if (!$user->is_active) {
            abort(403, 'Akun tidak aktif.');
        }

        if (!$user->hasRole($role)) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}