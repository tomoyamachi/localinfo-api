<?php

return [
    'all' => [
        'main' => [
            'namespaces' => [
                'Treasure\Main\Controllers' => APP_DIR.'/main/controllers',
            ]
                 ],
        'v1' => [
            'namespaces' => [
                'Treasure\V1\Controllers' => APP_DIR.'/v1/controllers',
            ]
                 ],
        'tool' => [
            'namespaces' => [
                'Treasure\Tool\Controllers' => APP_DIR.'/tool/controllers',
            ]
        ],
    ]
];
