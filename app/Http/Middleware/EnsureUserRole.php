<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! Auth::check() || Auth::user()->role !== $role) {
            Auth::logout();

            return redirect()->route('login')->withErrors(['access' => 'Akses ditolak. Silakan login dengan akun yang sesuai.']);
        }

        return $next($request);
    }
}
