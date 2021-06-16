<?php

namespace App\Http\Controllers;

use App\Contracts\LanguageRepository;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function index(LanguageRepository $languages){
        $languages = collect($languages->active());
        
        return $languages;
    }

    public function setLocale($locale, LanguageRepository $languages){

        $languages = Arr::pluck($languages->active(), 'lang_code');
        
        if (! in_array($locale, $languages)) {
            abort(400);
        }
    
        session(['locale' => $locale]);
    
        return redirect('/login');
    }
}
