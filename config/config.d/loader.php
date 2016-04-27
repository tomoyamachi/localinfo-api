<?php

return [
    'all' => [
        'main' => [
            'namespaces' => [
                'Papi\Main\Controllers' => APP_DIR.'/main/controllers',
            ]
                 ],
        'v1' => [
            'namespaces' => [
                'Papi\V1\Controllers' => APP_DIR.'/v1/controllers',
            ]
                 ],
        'tool' => [
            'namespaces' => [
                'Papi\Tool\Controllers' => APP_DIR.'/tool/controllers',
            ]
        ],
    ]
];
