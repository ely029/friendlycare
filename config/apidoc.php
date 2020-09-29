<?php

return [
    'type' => 'laravel',

    'laravel' => [
        'autoload' => true,
        'docs_url' => '/docs/api',
        'middleware' => ['web', 'auth', 'route.access'],
    ],

    'postman' => [
        'enabled' => true,
    ],

    'routes' => [
        [
            'include' => [
                'api/cron'
            ],
            'apply' => [
                'headers' => [
                    'X-Appengine-Cron' => 'true',
                    'X-Forwarded-For' => '10.0.0.1',
                ],
            ],
        ],
        [
            'match' => [
                'domains' => [
                    '*',
                ],
                'prefixes' => [
                    'api/*',
                ],
            ],
            'exclude' => [
                'api/cron'
            ],
            'apply' => [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic {credentials}',
                ],
            ],
        ],
    ],

    'logo' => resource_path('docs/images/thinkbit.png'),

    'default_group' => 'Core',

    'example_languages' => [
        'bash',
        'javascript',
        'php',
        'python',
    ],
];
