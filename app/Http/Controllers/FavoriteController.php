<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function favorite(Vendor $vendor)
    {
        $user = Auth::check() ? Auth::user() : User::where('id', '=', '5')->inRandomOrder()->first();
        $user->favoriteVendors()->attach($vendor->id);
        return redirect()->back();
    }

    public function unfavorite(Vendor $vendor)
    {
        $user = Auth::check() ? Auth::user() : User::where('id', '=', '5')->inRandomOrder()->first();
        $user->favoriteVendors()->detach($vendor->id);
        return redirect()->back();
    }
}
