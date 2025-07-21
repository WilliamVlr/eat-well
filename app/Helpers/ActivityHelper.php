<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Models\UserActivity;

if (!function_exists('logActivity')) {
    function logActivity($status, $action, $object, $request = null)
    {
        $request = $request ?? request();
        $user = Auth::user();

        if (!$user) {
            return; // skip jika belum login
        }

        // Ambil URL sekarang dan referer
        $currentUrl = $request->fullUrl();
        $referer = $request->headers->get('referer');

        // Abaikan log jika halaman sekarang adalah /home DAN referer bukan dari /home
        if (
            $request->is('home') &&
            $referer &&
            !str_contains($referer, '/home')
        ) {
            return;
        }

        if (
            $request->is('cateringHomePage') &&
            $referer &&
            !str_contains($referer, '/cateringHomePage')
        ) {
            return;
        }

        

        $description = "{$user->name} as {$user->role->value} {$status} {$action} {$object}";

        UserActivity::create([
            'userId'      => Auth::user()->userId,
            'name'        => Auth::user()->name,
            'role'        => Auth::user()->role ?? '-',
            'url'         => $currentUrl,
            'description' => $description,
            'method'      => $request->method(),
            'ip_address'  => $request->ip(),
            'accessed_at' => now(),
        ]);
    }
}
