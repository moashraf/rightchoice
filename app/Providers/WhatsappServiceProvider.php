<?php

namespace App\Providers;

use App\Contracts\WhatsappProviderInterface;
use App\Services\Whatsapp\WhatsappBatchService;
use App\Services\Whatsapp\Providers\MockWhatsappProvider;
use App\Services\Whatsapp\Providers\UltraMsgWhatsappProvider;
use Illuminate\Support\ServiceProvider;

class WhatsappServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(WhatsappProviderInterface::class, function ($app) {
            $provider = config('whatsapp.default_provider', 'mock');
            return match ($provider) {
                'ultramsg' => new UltraMsgWhatsappProvider(),
                'mock'     => new MockWhatsappProvider(),
                default    => new MockWhatsappProvider(),
            };
        });

        $this->app->bind(WhatsappBatchService::class, function ($app) {
            return new WhatsappBatchService($app->make(WhatsappProviderInterface::class));
        });
    }

    public function boot(): void {}
}
