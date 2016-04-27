<?php

use Phalcon\DI;
use Phalcon\Mvc\Url;

$di = DI::getDefault();
$di->set('url', function () use ($di) {
    $url = new Url();
    $url->setBaseUri('');
    return $url;
});
