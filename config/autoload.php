<?php

define('CLASS_DIR', dirname(__DIR__ ) . DIRECTORY_SEPARATOR . "src");

spl_autoload_register(function ($className) {
    include str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, CLASS_DIR . DIRECTORY_SEPARATOR . $className. ".php");
});