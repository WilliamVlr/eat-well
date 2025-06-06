<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthManager extends Controller
{
    function loginRegister(){
        return view('loginRegister');
    }

    function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required | email | unique:users',
            'password' => 'required',
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
    
        if(!$user)
        {
            return redirect(route('login-register'))->with("error", "Registration failed, please try again.");
        }
        return redirect(route('login-register'))->with("success", "Registration success, login to access the app.");
    }


}
