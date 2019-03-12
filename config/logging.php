<?php

use Monolog\Handler\StreamHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'upload' => [
            'driver' => 'single',
            'path' => storage_path('logs/upload.log'),
            'level' => 'info',
        ],
        'setconfig' => [
            'driver' => 'single',
            'path' => storage_path('logs/config.log'),
            'level' => 'info',
        ],
        'artisan' => [
            'driver' => 'single',
            'path' => storage_path('logs/artisan.log'),
            'level' => 'info',
        ],
        'error' => [
            'driver' => 'single',
            'path' => storage_path('logs/error.log'),
            'level' => 'error',
        ],
        'ultra' => [
            'driver' => 'single',
            'path' => storage_path('logs/ultra.log'),
            'level' => 'warning',
        ],
        'login_true' => [
            'driver' => 'single',
            'path' => storage_path('logs/login.log'),
            'level' => 'info',
        ],
        'login_false' => [
            'driver' => 'single',
            'path' => storage_path('logs/login.log'),
            'level' => 'error',
        ],
 
        'create_true' => [
            'driver' => 'single',
            'path' => storage_path('logs/create.log'),
            'level' => 'info',
        ],
         'create_false' => [
            'driver' => 'single',
            'path' => storage_path('logs/create.log'),
            'level' => 'error',
        ],

        'update_true' => [
            'driver' => 'single',
            'path' => storage_path('logs/update.log'),
            'level' => 'info',
        ],
         'update_false' => [
            'driver' => 'single',
            'path' => storage_path('logs/update.log'),
            'level' => 'error',
        ],

        'delete_true' => [
            'driver' => 'single',
            'path' => storage_path('logs/delete.log'),
            'level' => 'info',
        ],
         'delete_false' => [
            'driver' => 'single',
            'path' => storage_path('logs/delete.log'),
            'level' => 'error',
        ],
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 7,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],
    ],

];
