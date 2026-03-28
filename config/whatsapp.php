<?php

return [
    'default_provider' => env('WHATSAPP_PROVIDER', 'mock'),

    'providers' => [
        'mock' => [
            'failure_rate' => env('WHATSAPP_MOCK_FAILURE_RATE', 0.0),
        ],
        'ultramsg' => [
            'instance_id' => env('ULTRAMSG_INSTANCE_ID', ''),
            'token'       => env('ULTRAMSG_TOKEN', ''),
        ],
    ],

    'queue' => env('WHATSAPP_QUEUE', 'whatsapp'),
];
