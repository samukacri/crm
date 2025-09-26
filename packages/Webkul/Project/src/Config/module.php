<?php

return [
    'routes' => [
        'admin' => [
            'prefix' => 'admin',
            'middleware' => ['web', 'admin_locale', 'user'],
            'files' => [
                __DIR__ . '/../Http/routes.php',
            ],
        ],
    ],
];