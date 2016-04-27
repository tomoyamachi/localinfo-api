<?php

use Phalcon\DI;
use Phalcon\Db\Adapter\Pdo\Mysql as Db;

$di = DI::getDefault();
$di->set('db', function () use ($di) {

    if (!$di->has('config')) {
        return;
    }
    $config = $di->get('config');


    $descriptor = $config->database->toArray();
    if ($config->database->get('initialize', false)) {
        unset($descriptor['dbname']);
    }
    $db = new Db($descriptor);

    return $db;
});
