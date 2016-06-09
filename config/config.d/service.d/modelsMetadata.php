<?php

use Phalcon\DI;
use Phalcon\Mvc\Model\MetaData\Apc as ApcMetaData;

$di = DI::getDefault();
$di->set('modelsMetadata', function () use ($di) {
    // Create a meta-data manager with APC
    $metaData = new ApcMetaData(
        array(
            "lifetime" => 86400,
            "prefix"   => "lapi-metadata"
        )
    );
    return $metaData;
});
