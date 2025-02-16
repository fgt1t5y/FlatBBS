<?php

return [
    'driver' => 'mysql',
    'host' => getenv("DATABASE_HOST"),
    'port' => getenv("DATABASE_PORT"),
    'database' => getenv("DATABASE_NAME"),
    'username' => getenv("DATABASE_USER"),
    'password' => getenv("DATABASE_PASSWORD"),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'strict' => true,
    'options' => [
        \PDO::ATTR_TIMEOUT => 3
    ],
];
