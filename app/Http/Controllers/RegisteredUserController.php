<?php

namespace App\Http\Controllers;

use GuzzleHttp\Promise\Create;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Vendor;

class RegisteredUserController extends Controller
{
    public function create(String $role)
    {
        if($role == "customer") return view('auth.register');
        else if($role == "vendor") return view('auth.vendorRegister');
        else return redirect('/');
    }

    public function store(Request $request, String $role)
    {
        $attrs = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required']
        ]);

        $attrs['role'] = Str::ucfirst($role);
        $user = User::create($attrs);


        if($role == 'vendor')
        {
            Vendor::create([
                'userId' => $user->userId,
            ]);
        }

        Auth::login($user);
        return redirect('/home');
    }

}
