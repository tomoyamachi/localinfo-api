<?php

return [
    'all' => [
        'main' => [
            'namespaces' => [
                'Lapi\Main\Controllers' => APP_DIR.'/main/controllers',
            ]
                 ],
        'v1' => [
            'namespaces' => [
                'Lapi\V1\Controllers' => APP_DIR.'/v1/controllers',
            ]
                 ],
        'tool' => [
            'namespaces' => [
                'Lapi\Tool\Controllers' => APP_DIR.'/tool/controllers',
            ]
        ],
    ]
];
