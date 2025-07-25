<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LanguageRequest $request)
    {
        $lang = $request->validated()['lang'];
        Session::put('lang', $lang);
        
        return redirect()->back();
    }
}
