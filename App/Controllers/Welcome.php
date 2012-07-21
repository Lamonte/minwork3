<?php
/**
 * Example Controller
 */
namespace App\Controllers;

class Welcome extends \Minwork\Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function action_index() {
        echo 'testing';
    }
}