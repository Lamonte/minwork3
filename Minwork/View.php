<?php
namespace Minwork;

class View {

    public $template    = null;
    public $ext         = 'php';
    public $_data       = array();

    public function __set($item, $value) {
        $this->_data[$item]     = $value;
    }

    public function __get($item) {
        
        if(isset($this->_data[$item])) {
            return $this->_data[$item];
        }

        return null;
    }


    public function __construct($template = null) {
        
        if(is_null($template)) {
            throw new \Exception("The template file can't be left blank");
        }

        //set template file
        $this->template = $template;
    }    

    public function render($output = false) {
        
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