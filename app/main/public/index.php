<?php
require_once __DIR__.'/.init.php';

use \Gpl\Mvc\Application\Launcher;
use \Treasure\Config\ProjectConfiguration\Main;

$launcher = new Launcher(new Main(APPLICATION_ENV));
$launcher->start();
