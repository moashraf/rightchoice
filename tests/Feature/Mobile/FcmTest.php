<?php

namespace Tests\Feature\Mobile;

use App\Models\FcmToken;
use App\Models\User;
use App\Services\FcmNotificationService;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Exception\Messaging\NotFound;
use Kreait\Firebase\Exception\Messaging\ServerUnavailable;
use Laravel\Sanctum\Sanctum;
use Mockery;

class FcmTest extends MobileTestCase
{
    private function user(string $email = 'one@example.com'): User
    {
        return User::create(['name' => 'Person', 'email' => $email, 'status' => 1]);
    }

    public function test_token_registration_requires_authentication(): void
    {
        $this->postJson('/api/fcm-token', ['token' => 'device'])->assertUnauthorized();
        $this->assertSame(0, FcmToken::count());
    }

    public function test_device_send_endpoint_requires_authentication(): void
    {
        $this->postJson('/api/fcm/send', [
            'token' => 'device',
            'message' => 'Hello',
        ])->assertUnauthorized();
    }

    public function test_device_send_endpoint_validates_payload_and_token_ownership(): void
    {
        $user = $this->user();
        Sanctum::actingAs($user);

        $this->postJson('/api/fcm/send', [])
            ->assertUnprocessable()
            ->assertJsonPath('message', 'Validation failed.')
            ->assertJsonValidationErrors(['token', 'message']);

        $this->postJson('/api/fcm/send', [
            'token' => 'another-users-device',
            'message' => 'Hello',
        ])->assertNotFound()
            ->assertJsonPath(
                'message',
                'The device token is not registered to the authenticated user.'
            );
    }

    public function test_authenticated_user_can_send_message_to_their_device(): void
    {
        $user = $this->user();
        $user->fcmTokens()->create(['token' => 'device']);

        $service = Mockery::mock(FcmNotificationService::class);
        $service->shouldReceive('sendToToken')
            ->once()
            ->withArgs(fn (User $target, string $token, string $title, string $body, array $data) =>
                $target->is($user)
                && $token === 'device'
                && $title === 'RightChoice'
                && $body === 'Hello from the API'
                && $data === ['screen' => 'home']
            )
            ->andReturn(['sent' => 1, 'removed' => 0]);
        $this->app->instance(FcmNotificationService::class, $service);

        Sanctum::actingAs($user);

        $this->postJson('/api/fcm/send', [
            'token' => 'device',
            'message' => 'Hello from the API',
            'data' => ['screen' => 'home'],
        ])->assertOk()
            ->assertJsonPath('data.sent', 1)
            ->assertJsonPath('data.removed', 0)
            ->assertJsonPath('message', 'Notification processed successfully.');
    }

    public function test_token_endpoints_return_explicit_validation_messages(): void
    {
        Sanctum::actingAs($this->user());

        $this->postJson('/api/fcm-token', [])
            ->assertUnprocessable()
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Validation failed.')
            ->assertJsonPath('errors.token.0', 'The device FCM token is required.');

        $this->deleteJson('/api/fcm-token', [])
            ->assertUnprocessable()
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Validation failed.')
            ->assertJsonPath('errors.token.0', 'The device FCM token is required.');
    }

    public function test_registration_sends_welcome_notification_to_the_registered_device(): void
    {
        $user = $this->user();
        $service = Mockery::mock(FcmNotificationService::class);
        $service->shouldReceive('sendToToken')
            ->once()
            ->withArgs(fn (User $target, string $token, string $title, string $body, array $data) =>
                $target->is($user)
                && $token === 'device'
                && $title === 'RightChoice'
                && $body === 'مرحبًا بك في RightChoice'
                && $data === ['type' => 'welcome', 'screen' => 'home']
            )
            ->andReturn(['sent' => 1, 'removed' => 0]);
        $this->app->instance(FcmNotificationService::class, $service);

        Sanctum::actingAs($user);

        $this->postJson('/api/fcm-token', ['token' => 'device'])
            ->assertOk()
            ->assertJsonPath('message', 'Device token registered and welcome notification processed.');
    }

    public function test_registration_is_idempotent_and_transfers_ownership(): void
    {
        $service = Mockery::mock(FcmNotificationService::class);
        $service->shouldReceive('sendToToken')
            ->times(3)
            ->andReturn(['sent' => 1, 'removed' => 0]);
        $this->app->instance(FcmNotificationService::class, $service);

        $first = $this->user();
        $second = $this->user('two@example.com');
        Sanctum::actingAs($first);
        $this->postJson('/api/fcm-token', ['token' => 'device'])->assertOk();
        $this->postJson('/api/fcm-token', ['token' => 'device'])->assertOk();
        Sanctum::actingAs($second);
        $this->postJson('/api/fcm-token', ['token' => 'device', 'user_id' => $first->id])->assertOk();
        $this->assertSame(1, FcmToken::count());
        $this->assertEquals($second->id, FcmToken::first()->user_id);
        Sanctum::actingAs($first);
        $this->deleteJson('/api/fcm-token', ['token' => 'device'])->assertOk();
        $this->assertSame(1, FcmToken::count());
        Sanctum::actingAs($second);
        $this->deleteJson('/api/fcm-token', ['token' => 'device'])->assertOk();
        $this->assertSame(0, FcmToken::count());
    }

    public function test_only_unregistered_tokens_are_removed_and_other_devices_are_sent(): void
    {
        $user = $this->user();
        $user->fcmTokens()->create(['token' => 'stale']);
        $user->fcmTokens()->create(['token' => 'valid']);
        $error = (new NotFound('Unregistered'))->withErrors(['error' => ['details' => [[
            '@type' => 'type.googleapis.com/google.firebase.fcm.v1.FcmError', 'errorCode' => 'UNREGISTERED',
        ]]]]);
        $messaging = Mockery::mock(Messaging::class);
        $messaging->shouldReceive('send')->once()->ordered()->andThrow($error);
        $messaging->shouldReceive('send')->once()->ordered()->andReturn(['name' => 'messages/test']);
        $result = (new FcmNotificationService($messaging))->sendToUser($user, 'Hello', 'Test', ['screen' => 'notifications']);
        $this->assertSame(['sent' => 1, 'removed' => 1], $result);
        $this->assertSame('valid', FcmToken::first()->token);
    }

    public function test_transient_failures_preserve_the_token(): void
    {
        $user = $this->user();
        $user->fcmTokens()->create(['token' => 'valid']);
        $messaging = Mockery::mock(Messaging::class);
        $messaging->shouldReceive('send')->once()->andThrow(new ServerUnavailable('Retry later'));
        try {
            (new FcmNotificationService($messaging))->sendToUser($user, 'Hello', 'Test');
            $this->fail('Expected the transient error to propagate.');
        } catch (ServerUnavailable $e) {
            $this->assertSame(1, FcmToken::count());
        }
    }
}
