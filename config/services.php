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

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID', '4d2984af86ff17ddce6e'),
        'client_secret' => env('GITHUB_CLIENT_SECRET', '738a41fc9416f82d2d43ad7f747490102409bdcc'),
        'redirect' => env('GITHUB_REDIRECT', 'http://localhost:3000/auth/github/callback'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID',
            '740459462855-u7qmhog5ki1lbfjm5jp09mdk4ojkp02q.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', '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'),
        'redirect' => env('GOOGLE_REDIRECT_URI', 'http://localhost:3000/auth/google/callback'),
    ],

    'telegram' => [
        'token' => env('TELEGRAM_BOT_TOKEN', '6183664646:AAHMLE4zkKB2KPnpTRJoewYIZ6pYo0yVdR4J'),
    ],
];
