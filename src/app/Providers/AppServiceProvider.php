<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.backend', 'App\Http\Composers\BackendComposer');
        view()->composer('layouts.senubackend', 'App\Http\Composers\BackendComposer');
        
        Relation::morphMap([
            'flightbookingrequests' => 'App\Flightbookingrequest',
            'paymentrequests' => 'App\Paymentrequest',
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
       		 $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
    	}
    }
}
