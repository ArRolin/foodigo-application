<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PWA Manifest
    |--------------------------------------------------------------------------
    |
    | Here you can configure the PWA manifest settings.
    |
    */

    'manifest' => [
        'name' => 'Foodigo - Food Delivery',
        'short_name' => 'Foodigo',
        'description' => 'Order delicious food online with Foodigo',
        'start_url' => '/',
        'display' => 'standalone',
        'background_color' => '#ffffff',
        'theme_color' => '#ff6b35',
        'orientation' => 'portrait',
        'scope' => '/',
        'lang' => 'en',
        'categories' => ['food', 'lifestyle', 'shopping'],
        'icons' => [
            [
                'src' => '/images/icons/icon-72x72.png',
                'sizes' => '72x72',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/images/icons/icon-96x96.png',
                'sizes' => '96x96',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/images/icons/icon-128x128.png',
                'sizes' => '128x128',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/images/icons/icon-144x144.png',
                'sizes' => '144x144',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/images/icons/icon-152x152.png',
                'sizes' => '152x152',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/images/icons/icon-192x192.png',
                'sizes' => '192x192',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/images/icons/icon-384x384.png',
                'sizes' => '384x384',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/images/icons/icon-512x512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ]
        ],
        'screenshots' => [
            [
                'src' => '/images/screenshots/desktop-1.png',
                'sizes' => '1280x720',
                'type' => 'image/png',
                'form_factor' => 'wide'
            ],
            [
                'src' => '/images/screenshots/mobile-1.png',
                'sizes' => '750x1334',
                'type' => 'image/png',
                'form_factor' => 'narrow'
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | PWA Service Worker
    |--------------------------------------------------------------------------
    |
    | Here you can configure the service worker settings.
    |
    */

    'service_worker' => [
        'enabled' => true,
        'scope' => '/',
        'start_url' => '/',
        'cache_name' => 'foodigo-cache-v1',
        'strategies' => [
            'css' => 'cache-first',
            'js' => 'cache-first',
            'images' => 'cache-first',
            'fonts' => 'cache-first',
            'api' => 'network-first'
        ],
        'exclude' => [
            '/admin/*',
            '/api/*',
            '/storage/*',
            '/uploads/*'
        ],
        'include' => [
            '/css/*',
            '/js/*',
            '/images/*',
            '/fonts/*'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | PWA Meta Tags
    |--------------------------------------------------------------------------
    |
    | Here you can configure the meta tags for PWA.
    |
    */

    'meta' => [
        'apple-mobile-web-app-capable' => 'yes',
        'apple-mobile-web-app-status-bar-style' => 'default',
        'apple-mobile-web-app-title' => 'Foodigo',
        'application-name' => 'Foodigo',
        'msapplication-TileColor' => '#ff6b35',
        'msapplication-config' => '/browserconfig.xml',
        'theme-color' => '#ff6b35'
    ]
]; 