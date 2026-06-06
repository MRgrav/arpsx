<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Services\AppwriteStorageService;
use App\Services\PocketBaseStorageService;
use App\Services\StorageServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AppwriteStorageService::class, function ($app) {
            return new AppwriteStorageService();
        });

        $this->app->singleton(PocketBaseStorageService::class, function ($app) {
            return new PocketBaseStorageService();
        });

        $this->app->singleton(StorageServiceInterface::class, function ($app) {
            $driver = env('FILESYSTEM_DRIVER', 'appwrite');
            if ($driver === 'pocketbase') {
                return $app->make(PocketBaseStorageService::class);
            }
            return $app->make(AppwriteStorageService::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
