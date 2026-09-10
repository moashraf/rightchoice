<?php

namespace Tests\Feature\Mobile;

use App\Models\User;
use App\Services\Auth\SocialTokenVerifier;
use Mockery;

class AppleWebAuthTest extends MobileTestCase
{
    private function mockAppleIdentity(array $claims = []): void
    {
        $verifier = Mockery::mock(SocialTokenVerifier::class);
        $verifier->shouldReceive('verify')
            ->once()
            ->with('apple', 'apple-identity-token')
            ->andReturn(array_merge([
                'sub' => 'apple-web-user-123',
                'email' => 'apple-web@example.com',
                'email_verified' => 'true',
            ], $claims));

        $this->app->instance(SocialTokenVerifier::class, $verifier);
    }

    public function test_apple_button_flow_creates_a_web_session_and_preserves_first_name(): void
    {
        $this->mockAppleIdentity();

        $response = $this->post('/ar/auth/apple', [
            'credential' => 'apple-identity-token',
            'name' => 'Apple Web User',
        ]);

        $user = User::where('provider', 'apple')->firstOrFail();

        $response->assertRedirect('/ar/dashboard');
        $this->assertAuthenticatedAs($user, 'web');
        $this->assertSame('Apple Web User', $user->name);
        $this->assertSame('apple-web@example.com', $user->email);
        $this->assertNull($user->password);
    }

    public function test_existing_apple_user_can_sign_in_when_later_token_omits_email_and_name(): void
    {
        $user = new User();
        $user->name = 'Original Apple Name';
        $user->email = 'apple-web@example.com';
        $user->password = null;
        $user->provider = 'apple';
        $user->provider_id = 'apple-web-user-123';
        $user->status = 1;
        $user->save();
        $this->mockAppleIdentity(['email' => null, 'email_verified' => null]);

        $this->post('/en/auth/apple', [
            'credential' => 'apple-identity-token',
        ])->assertRedirect('/en/dashboard');

        $this->assertAuthenticatedAs($user, 'web');
        $this->assertSame('Original Apple Name', $user->fresh()->name);
    }
}
