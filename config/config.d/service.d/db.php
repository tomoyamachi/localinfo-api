<?php

use Phalcon\DI;
use Phalcon\Db\Adapter\Pdo\Mysql as Db;

$di = DI::getDefault();

if (APPLICATION_ENV !== 'prod') {
    $di->set('profiler', function () {
            return new Phalcon\Db\Profiler();
    }, true);
}

$di->set('db', function () use ($di) {
    if (!$di->has('config')) {
        return;
    }
    $config = $di->get('config');

    $descriptor = $config->database->master->toArray();

    if ($config->database->get('initialize', false)) {
        unset($descriptor['dbname']);
    }
    $db = new Db($descriptor);

    // SQL実行ログを出力する
    if (APPLICATION_ENV !== 'prod') {
        $eventsManager = new \Phalcon\Events\Manager();
        $eventsManager->attach('db', function ($event, $connection) use ($di) {
            if ($event->getType() == 'beforeQuery') {
                $di->get('profiler')->startProfile($connection->getSQLStatement());
            }
            if ($event->getType() == 'afterQuery') {
                $di->get('profiler')->stopProfile();
            }
        });
        $db->setEventsManager($eventsManager);
    }
    return $db;
});

$di->set('dbSlave', function () use ($di) {
    if (!$di->has('config')) {
        return;
    }
    $config = $di->get('config');

    $descriptor = $config->database->slave->toArray();

    if ($config->database->get('initialize', false)) {
        unset($descriptor['dbname']);
    }
    $db = new Db($descriptor);

    // SQL実行ログを出力する
    if (APPLICATION_ENV !== 'prod') {
        $eventsManager = new \Phalcon\Events\Manager();
        $eventsManager->attach('db', function ($event, $connection) use ($di) {
            if ($event->getType() == 'beforeQuery') {
                $di->get('profiler')->startProfile($connection->getSQLStatement());
            }
            if ($event->getType() == 'afterQuery') {
                $di->get('profiler')->stopProfile();
            }
        });
        $db->setEventsManager($eventsManager);
    }
    return $db;
});
