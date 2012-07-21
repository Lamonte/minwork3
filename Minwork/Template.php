<?php
/**
 * View\Template
 *
 * This class allows you to use the view class to wrap
 * other templates with a body template.  So say you have
 * similar body templates for a project and the only thing that
 * changes is the content.  Why load the header/footer every time?
 * That's because you shouldn't have to!
 */
namespace Minwork;

class Template extends Controller {

    /**
     * Template::$template_file
     *
     * This is the default template file that you wrap around
     * other view files.
     */
    public $template_file   = 'body';

    /**
     * Template::$template
     *
     * This is an instance of the \Minwork\View class
     * and you can assign variables to the view object
     * like you would normally in your controllers.  
     * eg.: $this->template->content, then you would edit
     * the App/View/body.php file or w/e default template file
     * you have set.
     */
    public $template        = null;

    /**
     * View::__construct()
     *
     * You want to setup an instance of the view class then
     * force them to call the parent::__construct() from the
     * controller.  
     */
    public function __construct() {
        parent::__construct();

        //assign template view object to the template variable
        $this->template = new View($this->template_file);
    }

    /**
     * View::__destruct()
     *
     * Once everything is done executing output the data to the
     * page for viewing.
     */
    public function __destruct() {
        $this->template->render(true);
    }

}