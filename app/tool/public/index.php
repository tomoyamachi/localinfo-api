<?php
require_once __DIR__.'/.init.php';

use \Gpl\Mvc\Application\Launcher;
use \Treasure\Config\ProjectConfiguration\Tool;

$launcher = new Launcher(new Tool(APPLICATION_ENV));
$launcher->start();
