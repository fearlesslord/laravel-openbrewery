<?php

namespace App\Providers;

use App\Repositories\BreweriesRepository;
use App\Repositories\Interfaces\BreweriesRepositoryInterface;
use App\Services\BreweriesService;
use App\Services\Interfaces\BreweriesServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BreweriesServiceInterface::class, BreweriesService::class);
        $this->app->bind(BreweriesRepositoryInterface::class, BreweriesRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
