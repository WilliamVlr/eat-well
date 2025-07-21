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

        // Abaikan log jika halaman sekarang adalah halaman untuk admin DAN user memiliki role admin
        if(
            ($request->is('view-all-vendors') && $user->role->value == 'Admin') ||
            ($request->is('view-all-packages') && $user->role->value == 'Admin') ||
            ($request->is('view-all-orders') && $user->role->value == 'Admin') ||
            ($request->is('view-all-users') && $user->role->value == 'Admin') ||
            ($request->is('view-all-logs') && $user->role->value == 'Admin') ||
            ($request->is('admin-dashboard') && $user->role->value == 'Admin') ||
            ($request->is('view-all-payment') && $user->role->value == 'Admin')
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
