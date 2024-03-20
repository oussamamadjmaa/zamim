<?php

return [
    'payfort' => [
        'key' => 'payfort',
        'title' => 'Amazon payment services',
        'logo' => 'https://m.media-amazon.com/images/G/01/APS/logo._CB1583329733_.svg',
        'is_default' => false,
        'active' => env('PM_PAYFORT_ACTIVE', true)
    ],
    'bank_transfer' => [
        'key' => 'bank_transfer',
        'title' => 'Bank transfer',
        'logo' => '',
        'is_default' => true,
        'active' => env('PM_BANK_TRANSFER_ACTIVE', true)
    ]
];
