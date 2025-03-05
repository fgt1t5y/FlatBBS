<?php

return [
    'user-content' => [
        'filesystem' => 'local',
        'config' => [
            'root' => getenv('LOCAL_USERCONTENT_ROOT'),
            'endpoint' => getenv('LOCAL_USERCONTENT_ENDPOINT'),
        ]
    ]
];
