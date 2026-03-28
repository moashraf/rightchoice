<?php

namespace Tests\Unit\Services\Sms;

use App\Services\Sms\MessagePersonalizer;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the MessagePersonalizer service.
 *
 * Tests placeholder replacement for SMS message templates.
 */
class MessagePersonalizerTest extends TestCase
{
    public function test_replaces_name_placeholder(): void
    {
        $result = MessagePersonalizer::personalize('Hello {name}', ['name' => 'Mohamed']);
        $this->assertEquals('Hello Mohamed', $result);
    }

    public function test_replaces_arabic_name(): void
    {
        $result = MessagePersonalizer::personalize('اهلا {name}', ['name' => 'محمد']);
        $this->assertEquals('اهلا محمد', $result);
    }

    public function test_replaces_multiple_placeholders(): void
    {
        $result = MessagePersonalizer::personalize('{name} مرحبا بك يا {name}', ['name' => 'احمد']);
        $this->assertEquals('احمد مرحبا بك يا احمد', $result);
    }

    public function test_handles_missing_name_gracefully(): void
    {
        $result = MessagePersonalizer::personalize('Hello {name}', []);
        $this->assertEquals('Hello ', $result);
    }

    public function test_no_placeholders_returns_template_as_is(): void
    {
        $result = MessagePersonalizer::personalize('No placeholders here', ['name' => 'Test']);
        $this->assertEquals('No placeholders here', $result);
    }

    public function test_preview_uses_sample_name(): void
    {
        $result = MessagePersonalizer::preview('مرحبا {name}');
        $this->assertEquals('مرحبا محمد', $result);
    }

    public function test_preview_with_custom_sample_name(): void
    {
        $result = MessagePersonalizer::preview('مرحبا {name}', 'احمد');
        $this->assertEquals('مرحبا احمد', $result);
    }
}
