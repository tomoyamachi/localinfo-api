<?php

use Phalcon\DI;
use Phalcon\Escaper;

$di = DI::getDefault();
$di->set('escaper', function () use ($di) {
    return new Escaper();
});
