<?php

use Phalcon\DI;
use Gpl\Mvc\Dispatcher;

$di = DI::getDefault();
$di->set('dispatcher', function () use ($di) {

    $config = $di->get('config');

    $dispatcher = new Dispatcher();

    $default    = $dispatcher->checkDefaultNamespace($config);
    $dispatcher->setDefaultNamespace($default);

    return $dispatcher;
});
