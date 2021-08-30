<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function English()
    {
        session()->get('language');
        session()->forget('language');
        Session::put('language','english');
        return redirect()->back();
    }

    public function Bengali()
    {
        session()->get('language');
        session()->forget('language');
        Session::put('language','bengali');
        return redirect()->back();
    }
    
}
