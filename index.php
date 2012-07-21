<?php

//get root directory
define('ROOT', str_replace('\\', '/', __DIR__) . '/');

//include important files
require_once ROOT . 'App/Config.php';
require_once ROOT . 'App/Routes.php';

/**
 * autoload classes
 *
 * @param string $class
 * @return void
 */
function __autoload($class) {
    //echo $class . '<br>' . "\n";
    //format class path correctly
    $class  = @explode('\\', $class);

    //require class file
    $path = ROOT . implode('/', $class) . '.php';
    if(file_exists($path)) {
        require $path;
    }
}

try {
    $route = new \Minwork\Route();
    $route->init();
} catch(Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n<br />";
    echo 'File: ' . $e->getFile() . "\n<br />";
    echo 'Line: ' . $e->getLine();
}