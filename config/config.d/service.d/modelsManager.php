<?php

use Phalcon\DI;
use Phalcon\Mvc\Model\Manager as ModelsManager;

$di = DI::getDefault();
$di->set('modelsManager', function () use ($di) {
    return new ModelsManager();
});
