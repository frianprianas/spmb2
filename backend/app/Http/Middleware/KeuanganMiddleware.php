<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KeuanganMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('keuangan')) {
            return redirect()->route('keuangan.login');
        }

        return $next($request);
    }
}
