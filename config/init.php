<?php
foreach (glob(__DIR__ . '/init.d/*.php') as $phpFile) {
    require_once $phpFile;
}
