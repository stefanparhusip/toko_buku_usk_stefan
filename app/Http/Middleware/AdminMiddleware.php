<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Allow only authenticated users with the admin role.
        if (! $request->user() || $request->user()->role !== 'admin') {
            return redirect()->route('landing')
                ->with('error', 'Akses ditolak. Halaman admin hanya untuk admin.');
        }

        return $next($request);
    }
}
