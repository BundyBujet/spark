<?php

namespace App\Providers;

use App\Repositories\TelegramFileRepository;
use App\Services\TelegramStorageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TelegramFileRepository::class, fn () => new TelegramFileRepository);
        $this->app->singleton(TelegramStorageService::class, function ($app) {
            return new TelegramStorageService(
                $app->make(\SergiX44\Nutgram\Nutgram::class),
                $app->make(TelegramFileRepository::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
