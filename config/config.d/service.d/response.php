<?php

use Phalcon\DI;
use Gpl\Http\Response;

$di = DI::getDefault();
$di->set('response', function () use ($di) {
    return new Response();
});
