<?php

namespace Tests\Feature\Sms;

use App\Models\SmsBatch;
use App\Models\SmsBatchRecipient;
use App\Models\User;
use App\Services\Sms\SmsBatchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Feature tests for the SMS batch service.
 *
 * Tests batch creation, recipient processing, and retry logic.
 */
class SmsBatchServiceTest extends TestCase
{
    use RefreshDatabase;

    private SmsBatchService $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Use mock provider for tests
        config(['sms.default_provider' => 'mock']);
        config(['sms.providers.mock.failure_rate' => 0.0]);

        $this->service = app(SmsBatchService::class);
    }

    public function test_create_batch_for_all_users(): void
    {
        // Create test users
        $admin = User::factory()->create(['name' => 'Admin', 'MOP' => '01012345678']);
        $user1 = User::factory()->create(['name' => 'محمد', 'MOP' => '01112345678']);
        $user2 = User::factory()->create(['name' => 'احمد', 'MOP' => '01212345678']);

        // Authenticate as admin
        $this->actingAs($admin, 'admin');

        $batch = $this->service->createBatch('مرحبا {name}', 'all_users');

        $this->assertNotNull($batch);
        $this->assertEquals('all_users', $batch->send_type);
        $this->assertEquals('مرحبا {name}', $batch->message_template);
        $this->assertEquals(3, $batch->total_recipients);

        // Verify personalized messages were created
        $recipients = $batch->recipients;
        $this->assertCount(3, $recipients);

        // Check that messages are personalized
        $mohamedRecipient = $recipients->firstWhere('recipient_name', 'محمد');
        $this->assertEquals('مرحبا محمد', $mohamedRecipient->personalized_message);

        $ahmedRecipient = $recipients->firstWhere('recipient_name', 'احمد');
        $this->assertEquals('مرحبا احمد', $ahmedRecipient->personalized_message);
    }

    public function test_create_batch_for_selected_users(): void
    {
        $admin = User::factory()->create(['name' => 'Admin', 'MOP' => '01012345678']);
        $user1 = User::factory()->create(['name' => 'محمد', 'MOP' => '01112345678']);
        $user2 = User::factory()->create(['name' => 'احمد', 'MOP' => '01212345678']);
        $user3 = User::factory()->create(['name' => 'علي', 'MOP' => '01512345678']);

        $this->actingAs($admin, 'admin');

        // Only send to user1 and user2
        $batch = $this->service->createBatch('Hello {name}', 'selected_users', [$user1->id, $user2->id]);

        $this->assertEquals(2, $batch->total_recipients);
        $this->assertEquals('selected_users', $batch->send_type);
    }

    public function test_invalid_numbers_are_marked(): void
    {
        $admin = User::factory()->create(['name' => 'Admin', 'MOP' => '01012345678']);
        $userValid = User::factory()->create(['name' => 'Valid', 'MOP' => '01112345678']);
        $userInvalid = User::factory()->create(['name' => 'Invalid', 'MOP' => 'abc123']);
        $userEmpty = User::factory()->create(['name' => 'Empty', 'MOP' => '']);

        $this->actingAs($admin, 'admin');

        $batch = $this->service->createBatch('Test {name}', 'all_users');

        // Admin + Valid should be valid, Invalid + Empty should be invalid
        $this->assertGreaterThanOrEqual(2, $batch->total_valid_numbers);
        $this->assertGreaterThanOrEqual(2, $batch->total_invalid_numbers);

        // Check that invalid recipients have correct status
        $invalidRecipient = $batch->recipients()->where('user_id', $userInvalid->id)->first();
        $this->assertEquals('invalid', $invalidRecipient->validation_status);
        $this->assertEquals('invalid_number', $invalidRecipient->send_status);
    }

    public function test_process_batch_sends_to_valid_recipients(): void
    {
        $admin = User::factory()->create(['name' => 'Admin', 'MOP' => '01012345678']);
        $user1 = User::factory()->create(['name' => 'محمد', 'MOP' => '01112345678']);

        $this->actingAs($admin, 'admin');

        $batch = $this->service->createBatch('مرحبا {name}', 'all_users');

        // Process the batch
        $this->service->processBatch($batch);

        $batch->refresh();

        // Should have sent to all valid recipients
        $this->assertGreaterThan(0, $batch->total_sent);
        $this->assertContains($batch->overall_status, ['completed', 'completed_with_failures']);
    }

    public function test_preview_recipient_counts(): void
    {
        User::factory()->create(['MOP' => '01012345678']);
        User::factory()->create(['MOP' => '01112345678']);
        User::factory()->create(['MOP' => 'invalid']);

        $counts = SmsBatchService::previewRecipientCounts('all_users');

        $this->assertEquals(3, $counts['total']);
        $this->assertEquals(2, $counts['valid']);
        $this->assertEquals(1, $counts['invalid']);
    }
}
