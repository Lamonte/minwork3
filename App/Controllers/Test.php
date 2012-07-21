<?php
/**
 * Example Controller using the template class 
 */
namespace App\Controllers;
use App\Models\Posts; // <- now I can usee the posts model class directly.

class Test extends \Minwork\Template {
    
    public function __construct() {
        parent::__construct();
    }

    public function testing() {}
    public function action_index() {

        $this->template->title      = "Page Title";
        $this->template->content    = "This is the page content";

        //$posts    = new Posts();
        //$posts->save();
    }
}