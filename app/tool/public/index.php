<?php
require_once __DIR__.'/.init.php';

use \Gpl\Mvc\Application\Launcher;
use \Papi\Config\ProjectConfiguration\Tool;

$launcher = new Launcher(new Tool('prod'));
$launcher->start();
