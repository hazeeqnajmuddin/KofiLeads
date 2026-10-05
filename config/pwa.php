<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Would you like the install button to appear on all pages?
      Set true/false
    |--------------------------------------------------------------------------
    */

    'install-button' => true,

    /*
    |--------------------------------------------------------------------------
    | PWA Manifest Configuration
    |--------------------------------------------------------------------------
    |  php artisan erag:update-manifest
    */

    'manifest' => [
        'name' => 'KofiLeads — Panel Admin',
        'short_name' => 'KofiLeads Admin',
        // NOTE: erag:update-manifest hard-codes start_url to '/'. This is an
        // admin-only PWA, so after running that command re-set start_url to
        // '/admin/dashboard' in public/manifest.json (done there already).
        'start_url' => '/admin/dashboard',
        'background_color' => '#0F1A45',
        'display' => 'standalone',
        'description' => 'Panel Pentadbir Lead Management Sales.',
        'theme_color' => '#1B2B6B',
        'icons' => [
            [
                'src' => 'images/pwa-192.png',
                'sizes' => '192x192',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'src' => 'images/pwa-512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'src' => 'images/pwa-512-maskable.png',
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'maskable',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Debug Configuration
    |--------------------------------------------------------------------------
    | Toggles the application's debug mode based on the environment variable
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Livewire Integration
    |--------------------------------------------------------------------------
    | Set to true if you're using Livewire in your application to enable
    | Livewire-specific PWA optimizations or features.
    */

    'livewire-app' => false,
];
