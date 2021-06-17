<?php

namespace App\Contracts;

use App\Models\User;

interface UserRepository 
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

    public function active();

    /**
     * Get active languages
     * 
     * @return array
     */

    public function findByUsername($username);

    public function insert(User $user);
}