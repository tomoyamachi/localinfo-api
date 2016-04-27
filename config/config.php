<?php
require_once __DIR__.'/../.init.php';
use Gpl\Config\Init;

$di = new \Phalcon\DI\FactoryDefault();
$config = new \Phalcon\Config();

$includeConfig = new \Phalcon\Config(Init::includeFiles(__DIR__.'/config.d/*.php', 'dev'));
$includeSchema = new \Phalcon\Config(Init::includeFiles(__DIR__.'/config.d/schema.d/*.php', 'dev', 'schema'));

$config->merge($includeConfig);
$config->merge($includeSchema);

foreach (glob(CONFIG_DIR.'/config.d/service.d/*.php') as $phpFile) {
    require_once $phpFile;
}

return $config;
