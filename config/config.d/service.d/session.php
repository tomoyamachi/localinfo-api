<?php

use Phalcon\DI;
use Phalcon\Session\Adapter\Files as Session;

$di = DI::getDefault();
$di->set('session', function () use ($di) {
    $session = new Session();
    $session->start();
    return $session;
});
