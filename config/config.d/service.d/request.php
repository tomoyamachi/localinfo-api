<?php

use Phalcon\DI;
use Phalcon\Http\Request;

$di = DI::getDefault();
$di->set('request', function () use ($di) {
    return new Request();
});
