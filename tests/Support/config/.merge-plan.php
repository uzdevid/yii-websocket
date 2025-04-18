<?php

declare(strict_types=1);

// Do not edit. Content will be replaced.
return [
    '/' => [
        'params' => [
            '/' => [
                'params.php',
            ],
        ],
        'params-centrifugo' => [
            '/' => [
                '$params',
            ],
        ],
        'di-centrifugo' => [
            '/' => [
                'websocket/di/*.php'
            ],
        ],
        'events' => [
            '/' => [
                'events.php',
            ],
        ],
        'events-fail' => [
            '/' => [
                'events-fail.php',
            ],
        ],
        'di-providers-centrifugo' => [
            '/' => [
                'di-providers.php',
            ],
        ],
        'di-delegates-centrifugo' => [
            '/' => [
                'di-delegates.php',
            ],
        ],
        'bootstrap-centrifugo' => [
            '/' => [
                'bootstrap.php',
            ],
        ],
        'routes' => [
            '/' => [
                'websocket/routes.php',
            ],
        ],
    ],
];
