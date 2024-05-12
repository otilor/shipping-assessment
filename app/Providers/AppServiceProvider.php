<?php

namespace App\Providers;

use App\Repositories\DeliveryRepository;
use App\Repositories\ShipmentRepository;
use App\Services\DeliveryService;
use App\Services\ShipmentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DeliveryRepository::class, DeliveryService::class);
        $this->app->singleton(ShipmentRepository::class, ShipmentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
