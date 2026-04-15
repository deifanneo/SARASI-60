<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session('role') !== 'siswa') {
            return redirect('/')->with('error', 'Silakan login sebagai siswa untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
