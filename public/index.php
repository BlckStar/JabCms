<?php

require_once '../config/bootstrap.php';

use Jab\App;
use Jab\Misc\Redirect\RedirectException;

$app = App::get();
try{
    $app->handle();
}

catch (RedirectException $exc){}
catch (Exception $exc) {
    l($exc->getTraceAsString());
}

