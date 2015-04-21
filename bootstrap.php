<?php
define("ROOT_PATH", dirname(__FILE__));
define("SRC_PATH", dirname(__FILE__) . "/src/");
define("TEST_FILES_PATH", dirname(__FILE__) . "/tests/test_files/");
define("VENDOR_PATH", dirname(__FILE__) . "/vendor/");
require_once ROOT_PATH . '/vendor/autoload.php';

function loadClass($path, $className){
    $classFullPath = $path . '/' . $className . '.php';
    if(file_exists($classFullPath)) {
        include_once($classFullPath);
        return true;
    }
}

spl_autoload_register(function ($class) {
    return loadClass(SRC_PATH, $class);
});