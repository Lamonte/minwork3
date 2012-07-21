<?php
/**
 * autoload classes
 *
 * @param string $class
 * @return void
 */
function __autoload($class) {
    
    //format class path correctly
    $class  = @explode('\\', $class);

    //require class file
    $path = ROOT . implode('/', $class) . '.php';

    //lets check if thie class exists and include it
    if(file_exists($path)) {
        require $path;
    }
}