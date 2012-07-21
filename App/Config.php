<?php

//current config that we'll be using
$conf   = 'default';

//url path to application
$config['default']['url']               = 'http://localhost/minwork3/';

/**
 * Database Settings
 *
 * We use a simple wrapper on top of PDO so refer to the manual
 * for connecting using the database driver that you migth use.
 * By default we're using the mysql dsn.  Pretty straight forward
 */
$config['default']['db']['dsn']         = ''; //'mysql:host=localhost;dbname=myblog';
$config['default']['db']['user']        = ''; //'root';
$config['default']['db']['password']    = '';