<?php

use Phalcon\DI;
use Phalcon\Tag;

$di = DI::getDefault();
$di->set('tag', function () use ($di) {
    return new Tag();
});
