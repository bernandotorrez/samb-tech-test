<?php

namespace App\Providers;

use App\Helpers\GetImage;
use App\Services\MySQL\AlurAduanService;
use App\Services\MySQL\ArticleService;
use App\Services\MySQL\BannerService;
use App\Services\MySQL\LayananService;
use App\Services\MySQL\LinkFormPelaporanService;
use App\Services\MySQL\PgpKeyService;
use App\Services\MySQL\RunningTextService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() 
    {
    
    }
}
