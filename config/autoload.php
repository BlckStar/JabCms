<?php

define('CLASS_DIR', dirname(__DIR__ ) . DIRECTORY_SEPARATOR . "src");
<<<<<<< HEAD
set_include_path(CLASS_DIR);

function autoload($className) {
    return spl_autoload(ucfirst($className));
}
spl_autoload_register("autoload");
=======

spl_autoload_register(function ($className) {
    include str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, CLASS_DIR . DIRECTORY_SEPARATOR . $className. ".php");
});
>>>>>>> b412ace39087d301d82b0c1dce4fbf0cef2f35db
