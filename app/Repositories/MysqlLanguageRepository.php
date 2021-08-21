<?php

namespace App\Repositories;

use App\Contracts\LanguageRepository;
use App\Models\Language;

class MysqlLanguageRepository implements LanguageRepository{
    
    /**
     * Get information on all languages in the database
     * 
     * @return array
     */

    public function all() 
    {
        return Language::get()->toArray();
    }

    /**
     * Get active languages
     * 
     * @return array
     */

    public function active($type) 
    {
        $languages = Language::where('active', true);
        if($type == "interface"){
            $languages = $languages->orderBy('lang_code')->get(['name', 'lang_code', 'icon']);
        }else{
            $languages = $languages->orderBy('trans_code')->get(['name', 'trans_code', 'icon']);
        }
        return $languages->toArray() ;
    }

    /**
     * Get active languages
     * 
     * @return array
     */

    public function find($lang_code) 
    {
        return Language::where('lang_code', $lang_code)->get()->toArray();
    }
}