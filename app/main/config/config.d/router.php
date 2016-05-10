<?php
return [
    'all' => [
        '/' => [
            'controller' => 'treasure',
            'action'     => 'index'
        ],
        '/:action' => [
            'controller' => 1,
            'action'     => 'index'
        ],
        '/:controller/:action' => [
            'controller' => 1,
            'action'     => 2
        ],
        '/sp/:controller/:action' => [
            'controller' => 1,
            'action' =>  2
        ]
    ]
];
