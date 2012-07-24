<?php
/**
 * Minwork\View
 *
 * This class will attempt to load a template file from the 
 * App\Views folder and then you have the option to return
 * or output the information directly.
 */
namespace Minwork;

class View {

    /**
     * View::$template
     *
     * This is the template path that we are trying to access
     * note: you shouldn't add a path name to this string
     */
    public $template    = null;

    /**
     * View::$ext
     *
     * This is the extention we'll be using for the template file
     */
    public $ext         = 'php';

    /**
     * View::$_data
     *
     * This is the data that we used to store class set variables
     */
    private $_data      = array();

    /**
     * View::$_helpers
     *
     * This stores assigned helper classes to be loaded into the helper 
     * object.
     */
    public static $_helpers   = array();

    /**
     * View::$helper
     *
     * This will be an empty object that stores helper classes
     */
    public $helper      = null;
    
    /**
     * View::__set()
     *
     * When they set a variable add that variable to the _data array
     * @param string $item
     * @param mixed $value
     * @return void
     */
    public function __set($item, $value) {
        $this->_data[$item]     = $value;
    }

    /**
     * View::__get()
     *
     * When they attempt to call a class variable we will attempt to
     * grab from the _data array and return null if it doesn't exists
     * @param string $item
     * @return mixed
     */
    public function __get($item) {
        
        if(isset($this->_data[$item])) {
            return $this->_data[$item];
        }

        return null;
    }

    /**
     * View::__construct()
     *
     * When they call the class construct you essentially want to
     * setup the template path so it can be rendered later
     * @param string $template
     * @return void
     */
    public function __construct($template = null) {
        
        if(is_null($template)) {
            throw new \Exception("The template file can't be left blank");
        }

        //set template file
        $this->template = $template;

        $this->helper   = new \stdClass();
    }    

    /**
     * View::setHelper()
     *
     * This function is used to assign helper classes
     * from the controller.
     * @param string $helper
     * @return void
     */
    public static function setHelper($helper) {
        if(!in_array($helper, self::$_helpers)) {
            self::$_helpers[] = $helper;
        }
    }

    /**
     * View::loadHelpers()
     *
     * This function attempts to load helper classes
     * and then assignt hem to the helper empty object.
     * @return void
     */
    public function loadHelpers() {
        foreach(self::$_helpers as $helper) {
            $class = 'App\\Helpers\\' . ucfirst(strtolower($helper));
            if(class_exists($class)) {
                $helper = strtolower($helper);
                $this->helper->{$helper} = new $class();
            }
        }
    }

    /**
     * View::render()
     *
     * We want to now output or return the template data to the user
     * this will also pass class variables straight to the template
     * @param boolean $output
     * @return string
     */
    public function render($output = false) {

        //try to load the helper classes
        $this->loadHelpers();

        //setup the helpers variable (overriding any other helper variables)
        $this->_data['helpers'] = $this->helper;

        //Turn on output buffering
        ob_start();
        
        //extract data into variables so they can be used within the template file
        extract($this->_data);

        //include path
        $include_file   = 'App/Views/' . $this->template . '.' . $this->ext;
        
        //make sure the file exists
        if(file_exists($include_file)) {
            require $include_file;
        } else {
            throw new \Exception("The view file you were trying to load does not exists: " . $include_file);
        }

        //Return the contents of the output buffer
        $html   = ob_get_contents();

        //Clean (erase) the output buffer and turn off output buffering
        ob_end_clean();

        //decide if we want to return or output the data
        if($output == false) {
            return $html;
        }

        echo $html;
    }
}