<?php
return [
    'GOOGLE_MAP_API' => '',

    'fcm_token' => [
        'customer' => ''
    ],

    'PAYMENT_TYPES' => [
        'cash',
        'k-net',
        'other'
    ],

    'CUSTOMER_TYPES' => [
        'individual',
        'each_active_customer'
    ],

    'NOTIFICATION_TYPES' => [
        'SMS',
        'email'
    ],

    's3' => [
        'access_key'          => '',
        'access_secret'       => '',
        'bucket'              => 'diet',
        'asset_url'           => env('APP_URL'),
        'canned_bucket'       => 'diet-private',
        'canned_asset_url'    => [
            'upload'   => 'https://diet-private.s3.ap-south-1.amazonaws.com/',
            'download' => 'https://content.diet.com/',
        ],
        'key_pair_for_signed' => '',
        'region'              => 'ap-south-1',
    ],
];
