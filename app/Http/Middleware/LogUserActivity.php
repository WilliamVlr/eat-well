<?php

namespace App\Http\Middleware;

use App\Models\UserActivity;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // ya ini kalau sudah login akan masuk ke database kalau tidak login tidak masuk
        Log::info('Middleware LogUserActivity DIPANGGIL untuk URL: ' . $request->fullUrl() . Auth::check());
        
        if (Auth::check()) {
            UserActivity::create([
                'userId'      => Auth::user()->userId,
                'name'        => Auth::user()->name,
                'role'        => Auth::user()->role ?? '-',
                'url'         => $request->fullUrl(),
                'method'      => $request->method(),
                'ip_address'  => $request->ip(),
                'accessed_at' => now(),
            ]);
        }

        return $next($request);
    }
}
