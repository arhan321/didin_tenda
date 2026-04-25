<?php

namespace App\Providers;

use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use App\Observers\DeliveryOrderObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //   \Illuminate\Support\Facades\URL::forceScheme('https');
        //   DeliveryOrder::observe(DeliveryOrderObserver::class);

          DB::listen(function ($query) {
            logger($query->sql);
        });
    }
}
