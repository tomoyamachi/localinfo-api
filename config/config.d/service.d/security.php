<?php

use Phalcon\DI;
use Phalcon\Security;

$di = DI::getDefault();
$di->set('security', function () use ($di) {
    return new Security();
});
