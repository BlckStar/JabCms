<?php

require_once 'autoload.php';
chdir(dirname(__FILE__));
define('JAB_ROOT', dirname(dirname(__FILE__)));

function l() {
    echo "<pre>";
    foreach(func_get_args() as $arg) {
        var_dump($arg);
    }
    echo "</pre>";
}


use Jab\App;

$app = App::get();
$app->setConfig(include 'config.php');
