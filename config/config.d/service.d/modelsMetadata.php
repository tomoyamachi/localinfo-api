<?php

use Phalcon\DI;
use Phalcon\Mvc\Model\MetaData\Memory as ModelsMetadata;

$di = DI::getDefault();
$di->set('modelsMetadata', function () use ($di) {
    return new ModelsMetadata();
});
