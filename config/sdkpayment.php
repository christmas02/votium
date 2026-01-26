<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SDK Payment Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the configuration settings for the SDK Payment
    | integration. You can specify API keys, endpoints, and other relevant
    | settings required to connect and interact with the SDK Payment service.
    |
    */

    'HUB2_API_KEY' => env('HUB2_API_KEY', ''),
    'HUB2_MERCHANT_ID' => env('HUB2_MERCHANT_ID', ''),
    'HUB2_ENVIRONMENT' => env('HUB2_ENVIRONMENT', ''),
    'HUB2_BASE_URL' => env('HUB2_BASE_URL', ''),
    'HUB2_PAYMENT_INTENT_URL' => env('HUB2_PAYMENT_INTENT_URL', ''),
    'HUB2_MAKE_TRANSFER_URL' => env('HUB2_MAKE_TRANSFER_URL', ''),
    'timeout' => env('SDK_PAYMENT_TIMEOUT', 30),

    // Add other configuration settings as needed
];