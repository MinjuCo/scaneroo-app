<?php

namespace App\Providers;

use App\Contracts\LanguageRepository;
use App\Repositories\MysqlLanguageRepository;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    protected $repositories = [
        'LanguageRepository',
        'UserRepository'
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach($this->repositories as $repository){
            $this->app->bind('App\\Contracts\\'.$repository, 'App\\Repositories\\Mysql'.$repository);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
