<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()){
            App::setLocale(auth()->user()->interface_lang);
        }else{
            if($request->session()->has('locale')){
                App::setLocale(session('locale'));
            }else{
                App::setLocale(config('app.locale'));
            }
        }
        
        
        return view('home', [
            'user' => (auth()->user())?auth()->user():[],
        ]);
    }
}
