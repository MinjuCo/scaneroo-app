<?php

namespace App\Repositories;

use App\Contracts\UserRepository;
use App\Models\User;

class MysqlUserRepository implements UserRepository{
    
    /**
     * Get information on all languages in the database
     * 
     * @return array
     */

    public function all() 
    {
        return User::get()->toArray();
    }

    /**
     * Get active languages
     * 
     * @return array
     */

    public function active() 
    {
        return User::where('active', true)->get()->toArray();
    }

    /**
     * Get active languages
     * 
     * @return array
     */

    public function findByUsername($username) 
    {
        return User::where('username', $username)->get()->first();
    }

    /**
     * Get active languages
     * 
     * @return void
     */

    public function insert(User $user) 
    {
        $user->save();
    }
}