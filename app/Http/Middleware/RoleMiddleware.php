<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string $role
    ): Response {
        if (!session()->has('user_id')) {
            return redirect()
                ->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        
if (session('role') !== $role) {
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

    return redirect()
        ->route('login')
        ->with('error', 'Silakan login kembali.');
}

        return $next($request);
    }
}
