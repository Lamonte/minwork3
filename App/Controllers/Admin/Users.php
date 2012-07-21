<?php

namespace App\Controllers\Admin;
use Minwork\View; // <- can use the View class directly or just use new \Minwork\View()

class Users extends \Minwork\Controller {

    public function __construct() {
        parent::__construct();
    }

    public function actio_index() {
        echo 'admin controller users index';
    }

    public function action_create($param, $param2 = 0) {
        $view = new View("example");
        $view->example_php = $param;
        $view->render(true);
    }
}