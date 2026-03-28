<?php

namespace App\Services\Whatsapp\Providers;

use App\Contracts\WhatsappProviderInterface;
use App\Services\Whatsapp\WhatsappSendResult;
use Illuminate\Support\Str;

class MockWhatsappProvider implements WhatsappProviderInterface
{
    private float $failureRate;

    public function __construct()
    {
        $this->failureRate = config('whatsapp.providers.mock.failure_rate', 0.0);
    }

    public function getName(): string
    {
        return 'mock';
    }

    public function send(string $mobile, string $message): WhatsappSendResult
    {
        \Log::info('[MockWhatsappProvider] WhatsApp sent', ['mobile' => $mobile, 'message' => $message]);

        if ($this->failureRate > 0 && (mt_rand(1, 100) / 100) <= $this->failureRate) {
            return WhatsappSendResult::failure(
                'Mock provider: simulated WhatsApp send failure',
                json_encode(['mock' => true, 'status' => 'failed'])
            );
        }

        return WhatsappSendResult::success(
            'WA-MOCK-' . Str::uuid()->toString(),
            json_encode(['mock' => true, 'status' => 'sent'])
        );
    }
}
