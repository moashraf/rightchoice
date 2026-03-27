<?php

namespace App\Services\Sms\Providers;

use App\Contracts\SmsProviderInterface;
use App\Services\Sms\SmsSendResult;
use Illuminate\Support\Str;

/**
 * Mock SMS provider for development and testing.
 *
 * Simulates sending SMS without actually calling any external API.
 * Useful for local development, testing, and staging environments.
 *
 * Configurable failure rate via config('sms.providers.mock.failure_rate').
 */
class MockSmsProvider implements SmsProviderInterface
{
    private float $failureRate;

    public function __construct()
    {
        // Percentage of sends that should simulate failure (0.0 = none, 1.0 = all)
        $this->failureRate = config('sms.providers.mock.failure_rate', 0.0);
    }

    public function getName(): string
    {
        return 'mock';
    }

    /**
     * Simulate sending an SMS. Logs the message and returns success/failure based on failure rate.
     */
    public function send(string $mobile, string $message): SmsSendResult
    {
        // Log the simulated send for debugging
        \Log::info('[MockSmsProvider] SMS sent', [
            'mobile'  => $mobile,
            'message' => $message,
        ]);

        // Simulate random failures based on configured rate
        if ($this->failureRate > 0 && (mt_rand(1, 100) / 100) <= $this->failureRate) {
            return SmsSendResult::failure(
                'Mock provider: simulated send failure',
                json_encode(['mock' => true, 'status' => 'failed'])
            );
        }

        return SmsSendResult::success(
            'MOCK-' . Str::uuid()->toString(),
            json_encode(['mock' => true, 'status' => 'sent'])
        );
    }
}
