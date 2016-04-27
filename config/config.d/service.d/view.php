<?php

use Phalcon\DI;
use Phalcon\Mvc\View;

$di = DI::getDefault();

$di->set('view', function () use ($di) {
    $config = $di->getService('config')->getDefinition();
    $app = $config->app;

    $view = new View();
    $view->setViewsDir(APP_DIR.'/'.$app.'/views');
    $view->registerEngines([
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ]);

    return $view;
});
