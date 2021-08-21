<?php

namespace App\Http\Controllers;

use App\Contracts\LanguageRepository;
use Illuminate\Support\Arr;

class LanguageController extends Controller
{
    public function index(LanguageRepository $languages, $type){
        $languages = collect($languages->active($type));
        
        return $languages;
    }

    public function setLocale($locale, LanguageRepository $languages){

        $languages = Arr::pluck($languages->active('interface'), 'lang_code');
        
        if (! in_array($locale, $languages)) {
            abort(400);
        }
    
        session(['locale' => $locale]);
    
        return redirect('/login');
    }
}
