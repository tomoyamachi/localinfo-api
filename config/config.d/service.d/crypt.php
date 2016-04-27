<?php

use Phalcon\DI;
use Phalcon\Crypt;

$di = DI::getDefault();
$di->set('crypt', function () use ($di) {
    return new Crypt();
});
