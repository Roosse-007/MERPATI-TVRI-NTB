<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if (!auth()->check()) {

            abort(401);

        }


        if (!auth()->user()->can($permission)) {

            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');

        }


        return $next($request);
    }
}