<?php
namespace Minwork;

/**
 * Route class
 *
 * Allowing me to route the way the framework handles urls and
 * also allows you to manipulate the way the app handles the route
 * data.
 */
class Route {

    //array of custom routes
    public static $routes       = array();

    //array of controller folder paths
    public static $folders      = array();

    //array of the current route
    public static $routes_array = array(
        'folder'        => null,
        'controller'    => null,
        'action'        => null,
        'params'        => array(),
    );

    public static $default      = null;
    
    public function __construct() {}

    /**
     * Route::split_path()
     *
     * This function takes the current url path and then properly
     * format it into an array for later use.  Allowing us to
     * access the correct controllers and controller actions.
     * @return array
     */
    public function split_path($string = null) { 

        //get the current path
        $request_uri    = is_null($string) ? $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] : $string;

        //make sure we don't have multiple forward slashes after eachother
        $request_uri    = preg_replace("/\/+/", '/', $request_uri);

        //strip _GET data 
        $request_uri    = preg_replace("/\?.*/i", '', $request_uri);

        //get the config url
        $config_url     = preg_replace("/^.*\:\/\//i", '', Config::Item('url'));

        //remove config url from current path
        $request_uri    = str_replace($config_url, '', $request_uri);

        //trim beginning and ending forward slashes
        $request_uri    = $this->trim_slashes($request_uri);

        //lets explode the current path into an array
        $path           = @explode("/", $request_uri);

        //remove empty array spots
        $path_tmp       = array();

        foreach($path as $p) {
            
            //skip empty strings
            if(empty($p)) continue;

            $path_tmp[] = $p;

        }

        $path   = $path_tmp;

        return empty($path) ? array() : $path;
    }

    public function trim_slashes($string) {

        //remove forward slashes from the beginning and ending of the current path
        $string     = preg_replace("/^\/|\/$/i", '', $string);

        return $string;
    }

    /**
     * Route::set()
     *
     * This function allows us to set custom routes to certain
     * controllers.  The custom routes can also be regular expressions
     * if $regex is set to true.
     * @param string    $find 
     * @param string    $replace
     * @param boolean   $regex      - tells the script of regex is enabled
     * @return void
     */
    public static function set($find, $replace, $regex = false) {
        self::$routes[] = array($find, $replace, $regex);
    }

    public static function set_default($path) {
        self::$default  = $path;
    }

    public function register_default() {

        if(!is_null(self::$default)) {
            
            $default_path   = $this->split_path(self::$default);

            //set default path
            $this->set_path($default_path);
        }
    }

    /**
     * Route::register_controller_path()
     *
     * This function would allow you to ask the framework to look
     * for this folder instead of the root controller folder when
     * being called from the url.  Allowing you to have sub folders
     * and possibly unlimited sub folders where you call your
     * controller classes from.
     * @return void
     */
    public static function register_controller_path($path) {
        self::$folders[] = $path;
    }

    public function init() {

        //get the current path
        $current_path   = $this->split_path();

        //setup the controller properly
        $this->set_path($current_path);

        //start rewrouting
        $this->reroute();

        //lets try loading the current controller if exists
        $this->load_controller();

    }

    public function set_path($current_path) {

        $current_folder = null;

        //var_dump(array_shift($current_path));

        //lets make sure the curreht path isn't empty
        if(count($current_path) > 0) {
            
            //lets try to get the correct controller folder
            $folders = array();

            foreach(self::$folders as $folder) {
                $folders[] = $this->trim_slashes($folder);
            }

            //loop through the folders array to check if the current path starts with this
            foreach($folders as $folder) {

                if($folder ==  $current_path[0]) {

                    //are we in a sub folder?
                    $current_folder = $folder;

                    //remove the first item in the array
                    array_shift($current_path);

                    break;
                }
            }

            //setup routes array
            if(!is_null($current_folder)) {
                self::$routes_array['folder'] = $current_folder;
            }

            if(!empty($current_path)) {
                self::$routes_array['controller'] = current($current_path);
                array_shift($current_path);
            }

            if(!empty($current_path)) {
                self::$routes_array['action'] = current($current_path);
                array_shift($current_path);
            }

            if(!empty($current_path)) {
                
                $params     = array();
                
                foreach($current_path as $_path) {
                    $params[]   = $_path;
                }

                self::$routes_array['params']   = $params;
            }
        } else {

            //lets attempt to set the default controller
            $this->register_default();
        }
    }

    public function reroute() {

        $current_path       = $this->split_path();
        $current_path_str   = implode('/', $current_path);

        //loop through the user set routes
        foreach(self::$routes as $route) {

            //check if we're using regular expressions or not
            $regex = isset($route[2]) && $route[2] == true ? $route[0] : null;

            //check if there was any matches of the current route
            if(preg_match('/' . $regex . '/i', $current_path_str, $matches)) {

                //there was only one match which had no params, so lets remove all the $ signs
                if(count($matches) == 1) {
                    $route[1]   = preg_replace('/\$\d+/', '', $route[1]);
                } else {

                    foreach($matches as $id => $match) {
                        if($id == 0) continue;

                        $route[1] = str_replace('$' . $id, $match, $route[1]);
                    }
                }

                //set the new path (overwriting any controllers to this new controller)
                $new_path = $this->split_path($route[1]);
                $this->set_path($new_path);
            }
        }
    }

    public function load_controller() {

        //lets try loading the classes
        $routes         = self::$routes_array;

        $class_folder   = empty($routes['folder']) ? null : ucfirst(strtolower($routes['folder'])) . '\\';

        $controller     = 'App\\Controllers\\' . $class_folder . ucfirst(strtolower($routes['controller']));

        $method         = 'action_' . $routes['action'];

        $params         = $routes['params'];

        //check if the class exists
        if(class_exists($controller)) {
            
            $class  = new $controller();

            if(method_exists($class, $method)) {
                call_user_func_array(array($class, $method), $params);
            } else {
                if(method_exists($class, 'action_index')) {
                    call_user_func(array($class, 'action_index'));
                } else {
                    //throw exception
                    throw new \Exception("Couldn't load the required controller method '{$controller}::action_index'.");
                }
            }

        } else {

           //404
            //echo '404: page doesnt exists';
            $error404 = new View('404');
            $error404->render(true);

        }
    }
}