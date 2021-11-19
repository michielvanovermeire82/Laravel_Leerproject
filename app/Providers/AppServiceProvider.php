<?php

namespace App\Providers;

use App\Services\VismaRestApiService;
use Illuminate\Support\ServiceProvider;

use function _;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
