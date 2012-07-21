<?php

namespace App\Controllers;

class Welcome extends \Minwork\Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function action_home() {
        echo 'welcome home';
    }
}