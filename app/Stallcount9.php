<?php

require_once(dirname(__FILE__) . '/lib/SC9/Doctrine.php');

class Stallcount9 {
	
	/* static constants	 */
	const DB_MYSQL = "mysql";
	
	/* static variables */
	public static $path;
	public static $settings;
	public static $output;
	
	
	public function Stallcount9($config) {
		//path to root of stallcount9 app
		Stallcount9::$path = dirname(__FILE__)."/";
		
		//set class autoloader
		$this->registerAutoloader();
		
		//parse settings (Settings is temporary, should use Container -> dependency injection)
		Stallcount9::$settings = new SC9_Settings($config);
		
		//output controller
		Stallcount9::$output = new SC9_Output_TwigOutput(Stallcount9::$path.'../skin/'.Stallcount9::$settings->skin, Stallcount9::$path.'data/output/cache');
	}
	
	/**
	 * 
	 * Handle HTTP requests matching controller and action automatically
	 * @param Array $req request object ($_REQUEST usually)
	 */
	public function handleRequests($req) {
		$n = isset($req["n"]) ? $req["n"] : "";
		
		$xpl = explode("/", $n);
		$section 	= count($xpl) > 1 ? strtolower($xpl[1]) : "home";
		$action 	= count($xpl) > 2 ? strtolower($xpl[2]) : "index";		
		
		$class 	= "SC9_Controller_".ucfirst($section);
		$method	= $action."Action"; 
		
		if(class_exists($class)) {
			$controller = new $class;
			if(method_exists($controller, $method)) {
				$controller->{$method}($req);	
			}else{
				$controller->indexAction($req);
			}
		}else{
			//handle error (temp: neat error page)
			echo "Error: section not found";
			exit;
		}
	}
	
	
	
	
	/** 
	 * Register autoloaders used by stallcount9
	 */
	public function registerAutoloader() {
		ini_set('unserialize_callback_func', 'spl_autoload_call');
		spl_autoload_register(array('Doctrine', 'autoload'));
		spl_autoload_register(array('Stallcount9', 'autoload'));
	}
	
	
	/**
	 * 
	 * Autoloading function
	 * @param String $class name of class being autoloaded
	 */
    static public function autoload($class) {
		$file = Stallcount9::$path.'lib/'.str_replace('_', '/', $class).'.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
        
        //loading models
 		if (0 !== strpos($class, 'Base')) {
			if(file_exists($file = Stallcount9::$path.'lib/SC9/Model/'.$class.'.php')) {
				require $file;
 			}
		}else{
			if(file_exists($file = Stallcount9::$path.'lib/SC9/Model/generated/'.$class.'.php')) {
				require $file;
 			}			
		}
		
    }
	
	
}