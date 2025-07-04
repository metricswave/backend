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

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),

        'basic' => [
            'id' => env('STRIPE_BASIC_ID'),
            'monthly_price' => env('STRIPE_BASIC_MONTHLY_PRICE'),
            'eur_monthly_price' => env('STRIPE_BASIC_EUR_MONTHLY_PRICE'),
            'yearly_price' => env('STRIPE_BASIC_YEARLY_PRICE'),
            'eur_yearly_price' => env('STRIPE_BASIC_EUR_YEARLY_PRICE'),
        ],

        'starter' => [
            'id' => env('STRIPE_STARTER_ID'),
            'monthly_price' => env('STRIPE_STARTER_MONTHLY_PRICE'),
            'eur_monthly_price' => env('STRIPE_STARTER_EUR_MONTHLY_PRICE'),
            'yearly_price' => env('STRIPE_STARTER_YEARLY_PRICE'),
            'eur_yearly_price' => env('STRIPE_STARTER_EUR_YEARLY_PRICE'),
        ],

        'business' => [
            'id' => env('STRIPE_BUSINESS_ID'),
            'monthly_price' => env('STRIPE_BUSINESS_MONTHLY_PRICE'),
            'eur_monthly_price' => env('STRIPE_BUSINESS_EUR_MONTHLY_PRICE'),
            'yearly_price' => env('STRIPE_BUSINESS_YEARLY_PRICE'),
            'eur_yearly_price' => env('STRIPE_BUSINESS_EUR_YEARLY_PRICE'),
        ],

        'corporate' => [
            'id' => env('STRIPE_CORPORATE_ID'),
            'monthly_price' => env('STRIPE_CORPORATE_MONTHLY_PRICE'),
            'eur_monthly_price' => env('STRIPE_CORPORATE_EUR_MONTHLY_PRICE'),
            'yearly_price' => env('STRIPE_CORPORATE_YEARLY_PRICE'),
            'eur_yearly_price' => env('STRIPE_CORPORATE_EUR_YEARLY_PRICE'),
        ],
    ],

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
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_REDIRECT_URI', 'http://localhost:3000/auth/github/callback'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI', 'http://localhost:3000/auth/google/callback'),
    ],

    'google_maps' => [
        'key' => env('GOOGLE_MAPS_API_KEY'),
    ],

    'telegram-bot-api' => [
        'token' => env('TELEGRAM_BOT_TOKEN_V2', '6291171882:AAHpIsqmmu7lbO1D6pdjurSr1PI-m0BPevw'),
        'old_token' => env('TELEGRAM_BOT_TOKEN_OLD', '6183664646:AAHMLE4zkKB2KPnpTRJoewYIZ6pYo0yVdR4'),
    ],
];
