<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
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

    public function store(LoginRequest $request)
    {
        $attrs = $request->validated();

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
        Auth::logout();

        return redirect('/');
    }
}
