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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'slims' => [
        'enabled' => env('SLIMS_CONNECTION_ENABLED', false),
        'base_url' => env('SLIMS_BASE_URL', ''),
        'default_member_type_id' => env('SLIMS_DEFAULT_MEMBER_TYPE_ID', 1),
        'duration_years' => env('SLIMS_MEMBERSHIP_DURATION_YEARS', 1),
        'default_password' => env('SLIMS_PASSWORD_DEFAULT', '12345678'),
        'password_hash_algo' => env('SLIMS_PASSWORD_HASH_ALGO', 'md5'),
    ],

];
