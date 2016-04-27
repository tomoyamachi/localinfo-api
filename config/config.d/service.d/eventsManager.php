<?php

use Phalcon\DI;
use Phalcon\Events\Manager as EventsManager;

$di = DI::getDefault();
$di->set('eventsManager', function () use ($di) {
    return new EventsManager();
});
