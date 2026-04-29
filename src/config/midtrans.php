<?php

use Illuminate\Support\ServiceProvider;

return [
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'is_sanitized' => env('MIDTRANS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_3DS', true),
];
