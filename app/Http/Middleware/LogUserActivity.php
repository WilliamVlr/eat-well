<?php

namespace App\Http\Middleware;

use App\Models\User;
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
        // Sebelum request diteruskan, catat login atau akses
        $status = Auth::check() ? 'LOGIN' : 'GUEST';
        Log::info("User status: $status | URL: {$request->fullUrl()}");

        $description = Auth::user()->name . ' ' . Auth::user()->role;
        
        if (Auth::check()) {
            UserActivity::create([
                'userId'      => Auth::user()->userId,
                'name'        => Auth::user()->name,
                'role'        => Auth::user()->role ?? '-',
                'url'         => $request->fullUrl(),
                'description' => $description ,
                'method'      => $request->method(),
                'ip_address'  => $request->ip(),
                'accessed_at' => now(),
            ]);
        }
        return $next($request);
    }
}
