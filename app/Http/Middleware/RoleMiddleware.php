<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole; // Pastikan enum ini sesuai lokasi & nama file

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Jika belum login
        if (!$user) {
            return redirect('/login');
        }

        // Cek berdasarkan enum
        return match ($user->role) {
            UserRole::Admin => $next($request),
            UserRole::Vendor => redirect('/cateringHomePage'),
            UserRole::Customer => redirect('/home'),
            default => abort(403, 'Unauthorized role'),
        };
    }
}
