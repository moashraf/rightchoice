<?php

namespace Tests\Feature\Mobile;

use App\Services\Auth\SocialTokenVerifier;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;

class AppleTokenTest extends MobileTestCase
{
    private function token(array $claims = [], bool $wrongSignature = false): string
    {
        config(['services.apple.client_id' => 'com.rightchoiceco.app']);
        $key = openssl_pkey_new(['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
        $rsa = openssl_pkey_get_details($key)['rsa'];
        Cache::forget('social-auth.apple.keys');
        Http::preventStrayRequests();
        Http::fake(['appleid.apple.com/auth/keys' => Http::response(['keys' => [[
            'kid' => 'test-key', 'kty' => 'RSA', 'alg' => 'RS256', 'use' => 'sig',
            'n' => JWT::urlsafeB64Encode($rsa['n']), 'e' => JWT::urlsafeB64Encode($rsa['e']),
        ]]])]);
        if ($wrongSignature) {
            $key = openssl_pkey_new(['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
        }
        return JWT::encode(array_merge([
            'iss' => 'https://appleid.apple.com', 'aud' => 'com.rightchoiceco.app',
            'sub' => 'apple-subject', 'iat' => time(), 'exp' => time() + 300,
        ], $claims), $key, 'RS256', 'test-key');
    }

    public function test_valid_apple_signature_and_claims_are_accepted(): void
    {
        $claims = app(SocialTokenVerifier::class)->verify('apple', $this->token());
        $this->assertSame('apple-subject', $claims['sub']);
        Http::assertSentCount(1);
    }

    #[DataProvider('invalidClaims')]
    public function test_invalid_claims_are_rejected(array $claims): void
    {
        $token = $this->token($claims);
        $this->expectException(\UnexpectedValueException::class);
        app(SocialTokenVerifier::class)->verify('apple', $token);
    }

    public static function invalidClaims(): array
    {
        return [
            'wrong audience' => [['aud' => 'other.app']],
            'wrong issuer' => [['iss' => 'https://attacker.example']],
            'expired' => [['exp' => 1]],
            'missing expiry' => [['exp' => null]],
            'missing subject' => [['sub' => '']],
            'future issuance' => [['iat' => PHP_INT_MAX]],
        ];
    }

    public function test_forged_signature_is_rejected(): void
    {
        $token = $this->token([], true);
        $this->expectException(\UnexpectedValueException::class);
        app(SocialTokenVerifier::class)->verify('apple', $token);
    }
}
