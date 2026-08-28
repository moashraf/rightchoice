<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google_maps' => [
        'key' => env('GOOGLE_MAPS_API_KEY', ''),
    ],

    'fawry' => [
        'env' => env('FAWRY_ENV', env('APP_ENV') === 'production' ? 'production' : 'staging'),
        'merchant_code' => env('FAWRY_MERCHANT_CODE', 'TUDH+sU93QqTh4bRQqAadQ=='),
        'secure_key'    => env('FAWRY_SECURE_KEY', '160224c0e40347318144da5efa284eda'),
        'charge_url'    => env('FAWRY_CHARGE_URL', 'https://www.atfawry.com/ECommerceWeb/Fawry/payments/charge'),
        'status_url'    => env('FAWRY_STATUS_URL', 'https://www.atfawry.com/ECommerceWeb/Fawry/payments/status'),
        'plugin_js'     => 'https://www.atfawry.com/atfawry/plugin/assets/payments/js/fawrypay-payments.js',
        'plugin_css'    => 'https://www.atfawry.com/atfawry/plugin/assets/payments/css/fawrypay-payments.css',
        'staging' => [
            'merchant_code' => env('FAWRY_STAGING_MERCHANT_CODE', 'siYxylRjSPy8M+QempZXFw=='),
            'secure_key'    => env('FAWRY_STAGING_SECURE_KEY', '028b9a79aa104f2c9bd6c06ec97bf7cc'),
            'charge_url'    => env('FAWRY_STAGING_CHARGE_URL', 'https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/charge'),
            'status_url'    => env('FAWRY_STAGING_STATUS_URL', 'https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/status'),
            'plugin_js'     => 'https://atfawry.fawrystaging.com/atfawry/plugin/assets/payments/js/fawrypay-payments.js',
            'plugin_css'    => 'https://atfawry.fawrystaging.com/atfawry/plugin/assets/payments/css/fawrypay-payments.css',
        ],
        'webhook_url'   => env(
            'FAWRY_WEBHOOK_URL',
            rtrim(env('APP_URL', ''), '/') . '/api/fawry/payment-notification'
        ),
        'return_url_base' => rtrim((string) env('FAWRY_RETURN_URL_BASE', 'https://rightchoice-co.com'), '/'),
    ],

];
