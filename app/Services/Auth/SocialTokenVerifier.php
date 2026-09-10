<?php

namespace App\Services\Auth;

use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Google\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use UnexpectedValueException;

class SocialTokenVerifier
{
    public function verify(string $provider, string $token): array
    {
        if ($provider === 'google') {
            $clientId = (string) config('services.google.web_client_id');
            abort_if($clientId === '', 503, 'Social sign-in is not configured.');

            $claims = (new Client(['client_id' => $clientId]))->verifyIdToken($token);
            $audiences = [$clientId];
            $issuers = ['accounts.google.com', 'https://accounts.google.com'];
        } else {
            $audiences = array_values(array_unique(array_filter([
                (string) config('services.apple.client_id'),
                (string) config('services.apple.web_client_id'),
            ])));
            abort_if($audiences === [], 503, 'Social sign-in is not configured.');

            $keys = Cache::remember('social-auth.apple.keys', 3600, function () {
                return Http::connectTimeout(5)->timeout(10)
                    ->get('https://appleid.apple.com/auth/keys')->throw()->json();
            });
            // Only trust Apple's published RS256 signing keys.
            $keys['keys'] = array_values(array_filter($keys['keys'] ?? [], fn ($key) =>
                ($key['kty'] ?? null) === 'RSA' && ($key['alg'] ?? null) === 'RS256'));
            $claims = (array) JWT::decode($token, JWK::parseKeySet($keys, 'RS256'));
            $issuers = ['https://appleid.apple.com'];
        }

        if (!is_array($claims)
            || !in_array($claims['iss'] ?? null, $issuers, true)
            || !in_array($claims['aud'] ?? null, $audiences, true)
            || !is_string($claims['sub'] ?? null) || $claims['sub'] === ''
            || strlen($claims['sub']) > 191
            || !is_numeric($claims['exp'] ?? null) || $claims['exp'] <= time()
            || !is_numeric($claims['iat'] ?? null) || $claims['iat'] > time() + 60) {
            throw new UnexpectedValueException('Invalid social identity token.');
        }

        return $claims;
    }
}
