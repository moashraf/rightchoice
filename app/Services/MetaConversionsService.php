<?php

namespace App\Services;

use App\Models\SettingSite;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Meta Conversions API (Server-Side Events)
 *
 * Sends events to Facebook/Meta using the Conversions API (CAPI).
 * This works alongside the browser Pixel for deduplication.
 */
class MetaConversionsService
{
    protected ?string $pixelId;
    protected ?string $accessToken;
    protected ?string $testEventCode;
    protected bool $enabled;

    public function __construct()
    {
        $setting = SettingSite::first();

        $this->pixelId        = $setting?->fb_pixel_id;
        $this->accessToken    = $setting?->fb_access_token;
        $this->testEventCode  = $setting?->fb_test_event_code;
        $this->enabled        = (bool) ($setting?->fb_conversions_api_enabled ?? false);
    }

    /**
     * Send a single event to Meta Conversions API.
     *
     * @param  string  $eventName   e.g. PageView, ViewContent, Lead, Purchase
     * @param  array   $userData    Hashed user data (email, phone, etc.)
     * @param  array   $customData  Event-specific data (content_ids, value, currency…)
     * @param  string|null $eventId Unique ID for deduplication with browser pixel
     * @return array|null           Meta API response or null if disabled/misconfigured
     */
    public function sendEvent(
        string $eventName,
        array  $userData    = [],
        array  $customData  = [],
        ?string $eventId    = null
    ): ?array {
        if (!$this->enabled || empty($this->pixelId) || empty($this->accessToken)) {
            return null;
        }

        $payload = [
            'data' => [
                [
                    'event_name'       => $eventName,
                    'event_time'       => time(),
                    'event_source_url' => request()->fullUrl(),
                    'action_source'    => 'website',
                    'event_id'         => $eventId ?? uniqid('ev_', true),
                    'user_data'        => $this->buildUserData($userData),
                    'custom_data'      => $customData,
                ],
            ],
        ];

        if (!empty($this->testEventCode)) {
            $payload['test_event_code'] = $this->testEventCode;
        }

        try {
            $response = Http::post(
                "https://graph.facebook.com/v19.0/{$this->pixelId}/events?access_token={$this->accessToken}",
                $payload
            );

            return $response->json();
        } catch (\Throwable $e) {
            Log::error('[MetaConversionsAPI] ' . $e->getMessage());
            return null;
        }
    }

    /** PageView event */
    public function pageView(array $userData = [], ?string $eventId = null): ?array
    {
        return $this->sendEvent('PageView', $userData, [], $eventId);
    }

    /** ViewContent – when a user views a property listing */
    public function viewContent(string $contentId, string $contentType, array $userData = [], ?string $eventId = null): ?array
    {
        return $this->sendEvent('ViewContent', $userData, [
            'content_ids'  => [$contentId],
            'content_type' => $contentType,
        ], $eventId);
    }

    /** Lead – when a user submits a contact/inquiry form */
    public function lead(array $userData = [], array $customData = [], ?string $eventId = null): ?array
    {
        return $this->sendEvent('Lead', $userData, $customData, $eventId);
    }

    /** Search event */
    public function search(string $searchString, array $userData = [], ?string $eventId = null): ?array
    {
        return $this->sendEvent('Search', $userData, ['search_string' => $searchString], $eventId);
    }

    /** Build hashed user data array */
    protected function buildUserData(array $raw): array
    {
        $ud = [];

        if (!empty($raw['email'])) {
            $ud['em'] = hash('sha256', strtolower(trim($raw['email'])));
        }
        if (!empty($raw['phone'])) {
            $ud['ph'] = hash('sha256', preg_replace('/[^0-9]/', '', $raw['phone']));
        }
        if (!empty($raw['first_name'])) {
            $ud['fn'] = hash('sha256', strtolower(trim($raw['first_name'])));
        }
        if (!empty($raw['last_name'])) {
            $ud['ln'] = hash('sha256', strtolower(trim($raw['last_name'])));
        }

        // Always include IP & User Agent (no hashing required)
        $ud['client_ip_address'] = request()->ip();
        $ud['client_user_agent'] = request()->userAgent();

        // Facebook Click ID (_fbc) and Browser ID (_fbp) from cookies
        if (request()->cookie('_fbc')) {
            $ud['fbc'] = request()->cookie('_fbc');
        }
        if (request()->cookie('_fbp')) {
            $ud['fbp'] = request()->cookie('_fbp');
        }

        return $ud;
    }

    public function isEnabled(): bool
    {
        return $this->enabled && !empty($this->pixelId) && !empty($this->accessToken);
    }

    public function getPixelId(): ?string
    {
        return $this->pixelId;
    }

    public function getGtmId(): ?string
    {
        $setting = SettingSite::first();
        return $setting?->gtm_id;
    }
}

