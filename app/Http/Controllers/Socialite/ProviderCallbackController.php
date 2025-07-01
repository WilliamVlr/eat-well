<?php

namespace App\Http\Controllers\Socialite;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Str;

class ProviderCallbackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $provider)
    {
        $role = session()->get('role');
        if(!in_array($provider, ['google'])){
            return redirect(route('register'))->withErrors(['provider'=>'Invalid provider']);
        }
        $socialUser = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([
            'provider_id' => $socialUser->id,
            'provider_name' => $provider,
        ], [
            'name' => $socialUser->name,
            'email' => $socialUser->email,
            'provider_token' => $socialUser->token,
            'provider_refresh_token' => $socialUser->refreshToken,
            'role' => Str::ucfirst($role)
        ]);

        if($user->role = UserRole::Vendor)
        {
            Vendor::firstOrCreate([
                'userId' => $user->userId,
            ]);
        }



        Auth::login($user, true);


        return redirect('/home');
    }
}
