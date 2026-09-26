<?php

namespace Tests\Feature\Mobile;

use App\Models\User;
use App\Services\Auth\SocialTokenVerifier;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use Mockery;

class SocialAuthTest extends MobileTestCase
{
    private function identity(string $provider = 'google', array $claims = []): void
    {
        $verifier = Mockery::mock(SocialTokenVerifier::class);
        $verifier->shouldReceive('verify')->with($provider, 'identity-token')->andReturn(array_merge([
            'sub' => 'provider-user-123', 'email' => 'person@example.com',
            'email_verified' => true, 'name' => 'Person',
        ], $claims));
        $this->app->instance(SocialTokenVerifier::class, $verifier);
    }

    public function test_google_creates_one_account_and_returns_a_valid_sanctum_token(): void
    {
        $this->identity();
        $payload = ['provider' => 'google', 'token' => 'identity-token'];
        $response = $this->postJson('/api/auth/social', $payload)->assertOk();
        $token = PersonalAccessToken::findToken($response->json('data.token'));
        $this->assertSame('mobile', $token->name);
        $this->assertSame($response->json('data.user.id'), $token->tokenable->id);
        $this->assertNull($token->tokenable->password);
        $this->assertEquals(0, $token->tokenable->phone_verfied_sms_status);
        $this->postJson('/api/auth/social', $payload)->assertOk();
        $this->assertSame(1, User::count());
        $this->assertSame(1, DB::table('users_priceing_sale')->count());
    }

    public function test_existing_email_is_not_silently_linked(): void
    {
        User::create(['name' => 'Existing', 'email' => 'person@example.com', 'status' => 1, 'password' => 'hash']);
        $this->identity();
        $this->postJson('/api/auth/social', ['provider' => 'google', 'token' => 'identity-token'])->assertStatus(409);
        $this->assertNull(User::first()->provider);
        $this->assertSame(0, PersonalAccessToken::count());
    }

    public function test_verified_google_email_signs_in_to_existing_active_phone_verified_account(): void
    {
        $user = User::create([
            'name' => 'Existing', 'email' => 'person@example.com', 'status' => 1,
            'MOP' => '01012345678', 'phone_verfied_sms_status' => 1,
            'password' => 'existing-password',
        ]);
        $this->identity();

        $response = $this->postJson('/api/auth/social', [
            'provider' => 'google', 'token' => 'identity-token',
        ])->assertOk()->assertJsonPath('data.user.id', $user->id);

        $token = PersonalAccessToken::findToken($response->json('data.token'));
        $this->assertSame($user->id, $token->tokenable->id);
        $this->assertSame(1, User::count());
        $this->assertNull($user->fresh()->provider);
        $this->assertSame('existing-password', $user->fresh()->password);
    }

    public function test_google_email_match_requires_verified_provider_email_and_verified_phone(): void
    {
        $user = User::create([
            'name' => 'Existing', 'email' => 'person@example.com', 'status' => 1,
            'MOP' => '01012345678', 'phone_verfied_sms_status' => 1,
            'password' => 'hash',
        ]);
        $payload = ['provider' => 'google', 'token' => 'identity-token'];

        $this->identity('google', ['email_verified' => false]);
        $this->postJson('/api/auth/social', $payload)->assertUnprocessable();

        $user->update(['phone_verfied_sms_status' => 0]);
        $this->identity();
        $this->postJson('/api/auth/social', $payload)->assertStatus(409);

        $user->update(['phone_verfied_sms_status' => 1, 'status' => 0]);
        $this->postJson('/api/auth/social', $payload)->assertStatus(409);

        $user->update(['status' => 1]);
        $user->delete();
        $this->postJson('/api/auth/social', $payload)->assertStatus(409);

        $this->assertSame(0, PersonalAccessToken::count());
    }

    public function test_apple_cannot_sign_in_to_existing_account_by_email(): void
    {
        User::create([
            'name' => 'Existing', 'email' => 'person@example.com', 'status' => 1,
            'MOP' => '01012345678', 'phone_verfied_sms_status' => 1,
            'password' => 'hash',
        ]);
        $this->identity('apple');

        $this->postJson('/api/auth/social', [
            'provider' => 'apple', 'token' => 'identity-token',
        ])->assertStatus(409);
        $this->assertSame(0, PersonalAccessToken::count());
    }

    public function test_inactive_and_deleted_accounts_cannot_sign_in(): void
    {
        $this->identity();
        $payload = ['provider' => 'google', 'token' => 'identity-token'];
        $this->postJson('/api/auth/social', $payload)->assertOk();
        User::first()->update(['status' => 0]);
        $this->postJson('/api/auth/social', $payload)->assertForbidden();
        User::first()->delete();
        $this->postJson('/api/auth/social', $payload)->assertForbidden();
        $this->assertSame(1, PersonalAccessToken::count());
    }

    public function test_apple_preserves_name_and_email_when_later_claims_omit_them(): void
    {
        $this->identity('apple', ['name' => null]);
        $this->postJson('/api/auth/social', ['provider' => 'apple', 'token' => 'identity-token', 'name' => 'Apple Person'])->assertOk();
        $this->identity('apple', ['name' => null, 'email' => null]);
        $this->postJson('/api/auth/social', ['provider' => 'apple', 'token' => 'identity-token'])
            ->assertOk()->assertJsonPath('data.user.name', 'Apple Person')
            ->assertJsonPath('data.user.email', 'person@example.com');
    }

    public function test_unverified_email_cannot_create_an_account(): void
    {
        $this->identity('google', ['email_verified' => false]);
        $this->postJson('/api/auth/social', ['provider' => 'google', 'token' => 'identity-token'])->assertUnprocessable();
        $this->assertSame(0, User::count());
    }

    public function test_invalid_input_and_token_do_not_create_an_account(): void
    {
        $this->postJson('/api/auth/social', ['provider' => 'facebook'])
            ->assertUnprocessable()
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Validation failed.')
            ->assertJsonValidationErrors(['provider', 'token'])
            ->assertJsonPath('errors.provider.0', 'The provider must be either google or apple.')
            ->assertJsonPath('errors.token.0', 'The provider token field is required.');
        $verifier = Mockery::mock(SocialTokenVerifier::class);
        $verifier->shouldReceive('verify')->andThrow(new \UnexpectedValueException('Bad signature'));
        $this->app->instance(SocialTokenVerifier::class, $verifier);
        $this->postJson('/api/auth/social', ['provider' => 'google', 'token' => 'bad'])->assertUnauthorized();
        $this->assertSame(0, User::count());
    }
}
