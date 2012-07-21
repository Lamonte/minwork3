<?php
/**
 * Minwork\Database
 *
 * Simple PDO wrapper that we'll add more functionality to soon enough.
 */
namespace Minwork;

class Database extends \PDO {
   
    /** 
     * Database::__construct()
     *
     * Calls the PDO construct to connect to the database
     */
    public function __construct($dsn, $username, $password) {
        parent::__construct($dsn, $username, $password);
    }

}