<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        $attrs = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(6)],
        ]);

        $remember = request()->has('remember') ? true : false;
        if(!Auth::attempt($attrs, $remember)){
            throw ValidationException::withMessages([
                'email' => 'Credentials do not match',
                'password' => 'Credentials do not match'
            ]);
        }

        request()->session()->regenerate();
        return redirect('/home');

    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }
}
