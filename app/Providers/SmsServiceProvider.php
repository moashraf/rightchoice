<?php

namespace App\Providers;

use App\Contracts\SmsProviderInterface;
use App\Services\Sms\SmsBatchService;
use App\Services\Sms\Providers\MockSmsProvider;
use App\Services\Sms\Providers\VodafoneSmsProvider;
use Illuminate\Support\ServiceProvider;

/**
 * SMS module service provider.
 *
 * Registers the SMS provider binding based on the configured default provider.
 * Also registers the SmsBatchService as a singleton.
 */
class SmsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind the SMS provider interface to the configured implementation
        $this->app->bind(SmsProviderInterface::class, function ($app) {
            $provider = config('sms.default_provider', 'mock');

            return match ($provider) {
                'vodafone' => new VodafoneSmsProvider(),
                'mock'     => new MockSmsProvider(),
                default    => new MockSmsProvider(),
            };
        });

        // Register SmsBatchService with automatic provider injection
        $this->app->bind(SmsBatchService::class, function ($app) {
            return new SmsBatchService(
                $app->make(SmsProviderInterface::class)
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
