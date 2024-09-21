<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\ApplicationDetail;

class ApplicationDetailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
         // Fetch the first ApplicationDetail record
         $applicationDetail = ApplicationDetail::latest()->first();

         // Share it with all views
         view()->share('applicationDetail', $applicationDetail);
    }
}
