<?php

/**
 * SMS Module Configuration.
 *
 * Configure the default SMS provider and provider-specific credentials here.
 * Credentials can be overridden via .env variables for security.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default SMS Provider
    |--------------------------------------------------------------------------
    |
    | Which provider to use for sending SMS. Supported: "vodafone", "mock".
    | Use "mock" for development/testing to avoid real SMS charges.
    |
    */
    'default_provider' => env('SMS_PROVIDER', 'mock'),

    /*
    |--------------------------------------------------------------------------
    | SMS Providers
    |--------------------------------------------------------------------------
    |
    | Configuration for each supported SMS provider adapter.
    |
    */
    'providers' => [

        'vodafone' => [
            'url'         => env('SMS_VODAFONE_URL', 'https://e3len.vodafone.com.eg/web2sms/sms/submit/'),
            'account_id'  => env('SMS_VODAFONE_ACCOUNT_ID', ''),
            'password'    => env('SMS_VODAFONE_PASSWORD', ''),
            'sender_name' => env('SMS_VODAFONE_SENDER_NAME', 'RightChoice'),
            'secret_code' => env('SMS_VODAFONE_SECRET_CODE', ''),
        ],

        'mock' => [
            // Simulate failure rate (0.0 = always success, 1.0 = always fail)
            'failure_rate' => env('SMS_MOCK_FAILURE_RATE', 0.0),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | SMS Queue Settings
    |--------------------------------------------------------------------------
    |
    | Whether to process SMS sending via queue (recommended for production)
    | or synchronously (useful for testing).
    |
    */
    'queue' => env('SMS_QUEUE', 'sms'),

];
