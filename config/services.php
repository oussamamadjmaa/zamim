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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'aps' => [
        'merchant_identifier'       => env('APS_MERCHANT_ID'),
        'access_code'               => env('APS_ACCESS_CODE'),
        'SHARequestPhrase'          => env('APS_SHA_REQUEST_PHRASE'),
        'SHAResponsePhrase'         => env('APS_SHA_RESPONSE_PHRASE'),
        'SHAType'                   => env('APS_SHA_TYPE', 'sha256'),
        'sandbox_mode'              => env('APS_SANDBOX_MODE', true),

        // folder must be created before
        'log_path'                  => storage_path('logs/aps.log'),
        '3ds_modal'                 => true,
        'debug_mode'                => env('APS_DEBUG_MODE'),
        'locale'                    => 'en',
    ],
    'bank_transfer' => [
        'bank_name' => env('BANK_NAME'),
        'account_holder' => env('ACCOUNT_HOLDER'),
        'account_number' => env('ACCOUNT_NUMBER'),
        'IBAN'  => env('IBAN')
    ],
    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'phone_number' => env('TWILIO_PHONE_NUMBER'),
        'sandbox_mode' => env('TWILIO_SANDBOX_MODE'),
        'sandbox_number' => env('TWILIO_SANDBOX_NUMBER'),
    ]

];
