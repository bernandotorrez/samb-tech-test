<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\IndonesianDate;

class IndonesianDateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('IndonesianDate',function(){
            return new IndonesianDate();
        });
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
