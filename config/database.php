<?php

return [
    'default' => 'mysql',

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => 3306,
            'database' => 'flat_bbs',
            'username' => 'root',
            'password' => 'lyghj456',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'options' => [
                \PDO::ATTR_TIMEOUT => 3
            ]
        ],
    ],
];
