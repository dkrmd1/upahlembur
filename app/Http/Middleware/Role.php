<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek jika belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil role user
        $userRole = Auth::user()->role;

        // Jika role user tidak termasuk dalam yang diperbolehkan
        if (!in_array($userRole, $roles)) {
            // Jika ingin redirect
            // return redirect('/')->with('error', 'Akses ditolak.');

            // Atau gunakan abort untuk forbidden
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
