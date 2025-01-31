<?php

return [

    'global_url' => env('GLOBAL_URL'),
    'midtrans_merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    'midtrans_client_key' => env('MIDTRANS_CLIENT_KEY'),
    'midtrans_server_key' => env('MIDTRANS_SERVER_KEY'),
    'midtrans_is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'midtrans_snap_url' => env('MIDTRANS_SNAP_URL'),
    'midtrans_is_sanitized' => true,
    'midtrans_is_3ds' => true,

];
