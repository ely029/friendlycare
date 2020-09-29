<?php

return [

    'enabled' => env('FIREWALL_ENABLED', env('APP_ENV') !== 'testing'),

    'responses' => [

        'block' => [
            'view' => null,
            'redirect' => null,
            // @TB: Let's show our custom error page.
            'abort' => true,
            'code' => 403,
        ],

    ],

    'notifications' => [

        'mail' => [
            'enabled' => true,
            'name' => 'Laravel Firewall',
            // @TB: Simplify configuration by using the existing from email
            'from' => env('MAIL_FROM_ADDRESS', 'support@thinkbitsolutions.com'),
            // @TB: Send any notifications to support (must exist as a user).
            'to' => ['support@thinkbitsolutions.com'],
        ],

    ],

    'middleware' => [
        'login' => [
            // @TB: https://laravel.com/docs/6.x/authentication#login-throttling
            'enabled' => false,
        ],
    ],

];
