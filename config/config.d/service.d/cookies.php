<?php

use Phalcon\DI;
use Phalcon\Http\Response\Cookies;

$di = DI::getDefault();
$di->set('cookies', function () use ($di) {
    return new Cookies();
});
