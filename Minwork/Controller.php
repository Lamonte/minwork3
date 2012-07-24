<?php
/**
 * Minwork\Controller
 *
 * Controller parent class, no real functionality yet.
 * I decided to not have any loader classes as it would
 * be just as much coding to create a new instance of a model
 * than to call $this->load->library or $this->load->model
 * everytime.
 */
namespace Minwork;

class Controller {

    /**
     * Controller::__construct()
     *
     * No real functionality yet
     */
    public function __construct() {}

    /**
     * Controller::loadHelper()
     *
     * This function allows us to access helper classes
     * within the view class files when loaded. To access
     * the helper class you would do: $helper->classname->function()
     * inside the view file.
     * @param string $helper
     * @return void
     */
    public function loadHelper($helper) {
        View::set_helper($helper);
    }
    
}