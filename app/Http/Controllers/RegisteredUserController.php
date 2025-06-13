<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $attrs = request()->validate([
            'name' => ['required'],
            'email' => ['required','unique:users'],
            'password' => ['required', Password::min(6), 'confirmed']
        ]);

        $user = User::create($attrs);

        Auth::login($user);
        return redirect('/customer-first-page');
    }
}
