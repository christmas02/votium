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

    'PAYSTACK_BASE_URL' => env('PAYSTACK_BASE_URL', ''),
    'PAYSTACK_INITIALIZE_URL' => env('PAYSTACK_INITIALIZE_URL', ''),
    'PAYSTACK_CHARGE_URL' => env('PAYSTACK_CHARGE_URL', ''),
    'PAYSTACK_SECRET_KEY' => env('PAYSTACK_SECRET_KEY', ''),

    'HYPERFAST_BASE_URL' => env('HYPERFAST_BASE_URL', ''),
    'HYPERFAST_TOKEN_URL' => env('HYPERFAST_TOKEN_URL', ''),
    'HYPERFAST_PAYMENT_URL' => env('HYPERFAST_PAYMENT_URL', ''),
    'HYPERFAST_EMAIL' => env('HYPERFAST_EMAIL', ''),
    'HYPERFAST_PASSWORD' => env('HYPERFAST_PASSWORD', ''),
    'HYPERFAST_OTP_URL' => env('HYPERFAST_OTP_URL', ''),
    'HYPERFAST_VERIFICATION_URL' => env('HYPERFAST_VERIFICATION_URL', ''),
    'HYPERFAST_CALLBACK_URL' => env('HYPERFAST_CALLBACK_URL', 'http://votium.net/api/webhook/hyperfast'),




    'timeout' => env('SDK_PAYMENT_TIMEOUT', 30),

    // Add other configuration settings as needed
];