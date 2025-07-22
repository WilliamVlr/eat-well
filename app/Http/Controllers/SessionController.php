<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $attrs = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

        $remember = request()->has('remember') ? true : false;


        if(!Auth::attempt($attrs, $remember)){
            throw ValidationException::withMessages([
                'email' => 'Credentials do not match',
                'password' => 'Credentials do not match'
            ]);
        }
        else{
            request()->session()->regenerate();
            return redirect('/home');
        }


    }

    public function destroy()
    {
        logActivity('Successfully', 'Logged out', 'Eat-well');
        Auth::logout();

        return redirect('/');
    }
}
