<?php
return [
    'all' => [
        '/' => [
            'controller' => 'localinfo',
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
        '/:controller/:action/:int' => [
            'controller' => 1,
            'action'     => 2,
            'id'  => 3
        ],
        '/sp/:controller/:action' => [
            'controller' => 1,
            'action' =>  2
        ]
    ]
];
