<?php

namespace App\Providers;

use App\Contracts\NotificationGateway;
use App\Repositories\TelegramFileRepository;
use App\Services\LogNotificationGateway;
use App\Services\TelegramStorageService;
use App\Services\WhatsAppNotificationGateway;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NotificationGateway::class, function ($app) {
            $appkey = config('whatsapp.appkey');
            $authkey = config('whatsapp.authkey');
            if (config('whatsapp.enabled', true) && $appkey !== '' && $authkey !== '') {
                return $app->make(WhatsAppNotificationGateway::class);
            }
            return $app->make(LogNotificationGateway::class);
        });

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
