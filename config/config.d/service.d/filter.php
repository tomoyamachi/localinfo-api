<?php

use Phalcon\DI;
use Phalcon\Filter;

$di = DI::getDefault();
$di->set('filter', function () use ($di) {
    return new Filter();
});
