<?php

use Phalcon\DI;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

$di = DI::getDefault();
$di->set('transactionManager', function () use ($di) {
    return new TransactionManager();
});
