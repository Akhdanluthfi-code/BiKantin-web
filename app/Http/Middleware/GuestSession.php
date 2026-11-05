<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestSession
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('user_id')) {
            if (session('role') === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if (session('role') === 'kasir') {
                return redirect()->route('kasir.dashboard');
            }

            if (session('role') === 'siswa') {
                return redirect()->route('siswa.dashboard');
            }

            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return $next($request);
    }
}
