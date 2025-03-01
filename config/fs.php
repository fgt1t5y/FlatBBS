<?php

return [
    'local' => [
        'path' => base_path() . "/public/usercontent/"
    ],
    's3' => [
        'key' => getenv('S3_ACCESS_KEY'),
        'secret' => getenv('S3_SECRET_KEY'),
        'region' => getenv('S3_REGION'),
        'bucket' => getenv('S3_BUCKET'),
        'endpoint' => getenv('S3_ENDPOINT')
    ]
];
