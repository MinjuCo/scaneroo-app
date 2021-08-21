<?php

namespace App\Contracts;

interface LanguageRepository 
{
    /**
     * Get information on all languages in the database
     * 
     * @return array
     */

    public function all();

    /**
     * Get active languages
     * 
     * @return array
     */

    public function active($type);

    /**
     * Get active languages
     * 
     * @return array
     */

    public function find($lang_code);
}