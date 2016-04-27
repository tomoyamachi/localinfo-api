<?php

use Phalcon\DI;
use Phalcon\Annotations\Adapter\Memory as Annotations;

$di = DI::getDefault();
$di->set('annotations', function () use ($di) {
    return new Annotations();
});
