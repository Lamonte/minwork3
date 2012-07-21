<?php
/**
 * Minwork\Model
 *
 * This class is our base for handling model classes
 * lets us use the db class directly with models
 * so we won't have to call global $db everytime
 */
namespace Minwork;

class Model {
    
    /**
     * Model::$db
     *
     * Database instance
     */ 
    public $db  = null;

    /**
     * Setup the database instance to be used in our
     * model classes.
     */
    public function __construct() {
       
        global $db;

        //assign PDO object to make available for all model classes
        $this->db = $db;
    }
    
}