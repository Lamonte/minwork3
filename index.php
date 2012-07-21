<?php

//get root directory
define('ROOT', str_replace('\\', '/', __DIR__) . '/');

//include important files
require_once ROOT . 'Minwork/Autoload.php';
require_once ROOT . 'App/Config.php';
require_once ROOT . 'App/Routes.php';


try {

    //setup the database connection
    $db = new \Minwork\Database(
        $config[$conf]['db']['dsn'], 
        $config[$conf]['db']['user'], 
        $config[$conf]['db']['password']
    );

    //setup the routes
    $route = new \Minwork\Route();
    $route->init();

} catch(PDOException $e) {

    echo 'Database Error: ' . $e->getMessage() . "\n<br />";
    echo 'File: ' . $e->getFile() . "\n<br />";
    echo 'Line: ' . $e->getLine();

} catch(Exception $e) {

    echo 'Error: ' . $e->getMessage() . "\n<br />";
    echo 'File: ' . $e->getFile() . "\n<br />";
    echo 'Line: ' . $e->getLine();

}