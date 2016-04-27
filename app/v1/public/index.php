<?php
require_once __DIR__.'/.init.php';

use \Gpl\Mvc\Application\Launcher;
use \Treasure\Config\ProjectConfiguration\V1;

$launcher = new Launcher(new V1(APPLICATION_ENV));
$launcher->start();
