<?php

$configuration = new \Gpl\CLI\Config\ProjectConfiguration\Task('test');
$dispatcher = new \Phalcon\CLI\Dispatcher();
$dispatcher->setDI($configuration->getDI());
$dispatcher->setNamespaceName('Gpl\CLI\Task');
$configuration->getDI()->set('dispatcher', $dispatcher);

try {
    $dispatcher->setTaskName('database');
    $dispatcher->setActionName('drop');
    $dispatcher->dispatch();
    $dispatcher->setActionName('build');
    $dispatcher->dispatch();

    $dispatcher->setTaskName('migration');
    $dispatcher->setActionName('generate');
    $dispatcher->dispatch();
    $dispatcher->setActionName('run');
    $dispatcher->dispatch();

    $dispatcher->setTaskName('database');
    $dispatcher->setActionName('insertTestData');
    $dispatcher->dispatch();
} catch (\Phalcon\Exception $e) {
    echo $e->getMessage();
}
