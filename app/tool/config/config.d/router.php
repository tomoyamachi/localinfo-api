<?php
return [
    'all' => [
        '/' => [
            'controller' => 'tool',
            'action'     => 'index'
        ],
        '/:action' => [
            'controller' => 1,
            'action'     => 'index'
        ],
        '/report' => [
            'controller' => 'customer',
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
