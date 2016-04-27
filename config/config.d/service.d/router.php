<?php
use Phalcon\DI;
use Gpl\Mvc\Router;

$di = DI::getDefault();
$di->set('router', function () use ($di) {
    return new Router();
});
