<?php

return [
    'app' => [
        'metadata' => [
            'cache' => [
                'enabled' => true,
                'dir' => storage_path('dbadmin/attributes'),
            ],
        ],
        'assets' => [
            'export' => true,
            'minify' => true,
            'uri' => '/jaxon/app-0.14.0',
            'dir' => public_path('/jaxon/app-0.14.0'),
            // 'file' => '',
            'include' => [
                'dialog_code' => false,
            ],
        ],
        'dialogs' => [
            // Defined in the services/template.php file.
            'lib' => [
                'use' => ['bootstrap5', 'bulma', 'sweetalert', 'notyf'],
            ],
        ],
        'storage' => [
            'stores' => [
                'uploads' => [
                    'adapter' => 'local',
                    'dir' => storage_path('/uploads'),
                ],
                'exports' => [
                    'adapter' => 'local',
                    'dir' => storage_path('/exports'),
                ],
            ],
        ],
        'upload' => [
            'enabled' => true,
            'files' => [
                'sql_files' => [
                    'storage' => 'uploads',
                ],
            ],
        ],
    ],
    'lib' => [
        'core' => [
            'debug' => [
                'on' => false,
                'verbose' => false,
            ],
            // 'request' => [
            //     'uri' => '',
            // ],
            'prefix' => [
                'class' => '',
            ],
        ],
        'js' => [
            'lib' => [
                'uri' => '/jaxon/lib-5.2.5',
            ],
        ],
    ],
];
