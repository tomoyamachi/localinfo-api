<?php

use Phalcon\DI;
use Phalcon\Flash\Direct as Flash;

$di = DI::getDefault();
$di->set('flash', function () use ($di) {
    return new Flash();
});
