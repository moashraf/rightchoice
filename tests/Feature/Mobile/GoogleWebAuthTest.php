<?php

namespace Tests\Feature\Mobile;

use App\Models\User;
use App\Services\Auth\SocialTokenVerifier;
use Mockery;

class GoogleWebAuthTest extends MobileTestCase
{
    private function mockGoogleIdentity(array $claims = []): void
    {
        $verifier = Mockery::mock(SocialTokenVerifier::class);
        $verifier->shouldReceive('verify')
            ->once()
            ->with('google', 'google-id-token')
            ->andReturn(array_merge([
                'sub' => 'google-web-user-123',
                'email' => 'web@example.com',
                'email_verified' => true,
                'name' => 'Web User',
            ], $claims));

        $this->app->instance(SocialTokenVerifier::class, $verifier);
    }

    public function test_google_button_flow_creates_a_web_session(): void
    {
        $this->mockGoogleIdentity();

        $response = $this->post('/ar/auth/google', [
            'credential' => 'google-id-token',
        ]);

        $user = User::where('provider', 'google')->firstOrFail();

        $response->assertRedirect('/ar/dashboard');
        $this->assertAuthenticatedAs($user, 'web');
        $this->assertSame('web@example.com', $user->email);
        $this->assertNull($user->password);
    }

    public function test_existing_email_is_not_silently_linked_on_the_web(): void
    {
        User::create([
            'name' => 'Existing User',
            'email' => 'web@example.com',
            'password' => 'hash',
            'status' => 1,
        ]);
        $this->mockGoogleIdentity();

        $response = $this->from('/ar/login')->post('/ar/auth/google', [
            'credential' => 'google-id-token',
        ]);

        $response->assertRedirect('/ar/login');
        $response->assertSessionHasErrors('google');
        $this->assertGuest('web');
        $this->assertNull(User::first()->provider);
    }
}
