<?php

define('CLASS_DIR', dirname(__DIR__ ) . DIRECTORY_SEPARATOR . "src");
set_include_path(CLASS_DIR);

function autoload($className) {
    return spl_autoload(ucfirst($className));
}
spl_autoload_register("autoload");