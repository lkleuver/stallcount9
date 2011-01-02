<?php

require_once(dirname(__FILE__) . '/lib/SC9/Doctrine.php');

class Stallcount9 {
	
	/* static constants	 */
	const DB_MYSQL = "mysql";
	
	/* static variables */
	public static $path;
	public static $settings;
	
	//twig
	private $output;
	
	//doctirne
	private $manager;
	private $conn;
	
	public function Stallcount9($config) {
		//path to root of stallcount9 app
		Stallcount9::$path = dirname(__FILE__)."/";
		
		//set class autoloader
		$this->registerAutoloader();
		
		//parse settings (Settings is temporary, should use Container -> dependency injection)
		Stallcount9::$settings = new SC9_Settings($config);
		
		//output controller
		$this->output = new SC9_Output_TwigOutput(Stallcount9::$path.'../skin/'.Stallcount9::$settings->skin, Stallcount9::$path.'data/output/cache');
		
		$this->manager = Doctrine_Manager::getInstance();

		$connStr = sprintf('%s://%s:%s@%s/%s', Stallcount9::$settings->database['type'], Stallcount9::$settings->database['user'], Stallcount9::$settings->database['password'], Stallcount9::$settings->database['host'], Stallcount9::$settings->database['name']);
		$this->conn = Doctrine_Manager::connection($connStr);
	}
	
	/**
	 * 
	 * Handle HTTP requests matching controller and action automatically
	 * @param Array $req request object ($_REQUEST usually)
	 */
	public function handleRequests() {
		$n = isset($_GET["n"]) ? $_GET["n"] : "";
		
		$xpl = explode("/", $n);
		if(count($xpl) > 0) {
			array_shift($xpl); //drop the prepending slash
		}
		$section 	= count($xpl) > 0 ? array_shift($xpl) : "home";
		$action 	= count($xpl) > 0 ? array_Shift($xpl) : "index";	
		
		
		$class 	= "SC9_Controller_".ucfirst($section);
		$method	= $action."Action"; 
		
		if(class_exists($class)) {
			$controller = new $class($this->output, $xpl);
			if(method_exists($controller, $method)) {
				$controller->{$method}();	
			}else{
				$controller->indexAction();
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