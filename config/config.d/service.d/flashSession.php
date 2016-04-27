<?php

use Phalcon\DI;
use Phalcon\Flash\Session as FlashSession;

$di = DI::getDefault();
$di->set('flashSession', function () use ($di) {
    return new FlashSession();
});
