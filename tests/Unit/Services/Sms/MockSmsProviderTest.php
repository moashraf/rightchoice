<?php

namespace Tests\Unit\Services\Sms;

use App\Services\Sms\Providers\MockSmsProvider;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the MockSmsProvider.
 */
class MockSmsProviderTest extends TestCase
{
    public function test_get_name_returns_mock(): void
    {
        // Override config for test
        config(['sms.providers.mock.failure_rate' => 0.0]);
        $provider = new MockSmsProvider();
        $this->assertEquals('mock', $provider->getName());
    }

    public function test_send_returns_success(): void
    {
        config(['sms.providers.mock.failure_rate' => 0.0]);
        $provider = new MockSmsProvider();
        $result = $provider->send('01012345678', 'Test message');
        $this->assertTrue($result->success);
        $this->assertNotNull($result->messageId);
        $this->assertStringStartsWith('MOCK-', $result->messageId);
    }
}
