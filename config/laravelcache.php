<?php
return [
    'default' => 'redis',
    'stores' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'lock_connection' => 'default',
        ]
    ],
    'prefix' => 'flatcached'
];
