<?php
/**
 * Example Model Class
 */
namespace App\Models;

class Posts extends \Minwork\Model {
    
    public function __construct() {
        
        //call parent construct so I can access the db variable
        parent::__construct();
    }

    /**
     * Example save function
     */
    public function save() {
        $query      = "INSERT INTO `test` (`test`) VALUES('testing')";
        $prepare    = $this->db->prepare($query);
        $prepare->execute();
    }
    
}