<?php

namespace App\Controllers;

class Test extends \Minwork\Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function testing() {echo'testing';}
    public function action_index() {
        echo 'home';
    }
}